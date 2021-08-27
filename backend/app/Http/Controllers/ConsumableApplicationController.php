<?php

namespace App\Http\Controllers;

use App\Http\Middleware\UserMid;
use App\Http\Requests\ConsumableRecordForm;
use App\Models\Consumable;
use App\Models\ConsumableApplication;
use Illuminate\Http\Request;

class ConsumableApplicationController extends Controller
{
    public function list()
    {
        return response()->json([
            'consumable_applications' => ConsumableApplication::latest()->paginate()->load(['consumable', 'applicant', 'approver']),
        ]);
    }

    public function paginationLength()
    {
        return response()->json([
            'pagination_length' => ConsumableApplication::paginate()->lastPage(),
        ]);
    }

    public function store(ConsumableRecordForm $request)
    {
        $consumable = Consumable::findOrFail($request->consumable_id);
        $consumable_application = new ConsumableApplication();
        $consumable_application->consumable_id = $request->consumable_id;
        $consumable_application->applicant_id = UserMid::$user->id;

        if ($consumable->need_approval) {
            $consumable->approvers()->findOrFail($request->approver_id);
            $consumable_application->approver_id = $request->approver_id;
            $consumable_application->status = 0;
        } else {
            $consumable_application->status = 1;
        }

        if ($request->number > $consumable->number) {
            return response()->json([
                'message' => '数量不够',
            ], 400);
        }

        $consumable_application->number = $request->number;
        $consumable_application->description = $request->description;
        $consumable_application->save();
        $consumable_application->updateConsumable();

        return response()->json([
            'consumable_application' => $consumable_application,
        ]);
    }

    public function index($id)
    {
        $consumable_application = ConsumableApplication::findOrFail($id);
        $consumable_application->consumable;
        $consumable_application->applicant;
        $consumable_application->approver;
        return response()->json([
            'consumable_application' => $consumable_application,
        ]);
    }

    public function edit($id)
    {
        $consumable_application = ConsumableApplication::findOrFail($id);
        return response()->json([
            'access' => $consumable_application->approver_id == UserMid::$user->id,
        ]);
    }

    public function update($id, Request $request)
    {
        $consumable_application = ConsumableApplication::findOrFail($id);

        if ($consumable_application->approver_id != UserMid::$user->id) {
            return response()->json([
                'message' => '需要审批人执行操作',
            ], 403);
        }

        if ($consumable_application->status != 0) {
            return response()->json([
                'message' => '已审批',
            ], 400);
        }

        if ($request->status != -1 && $request->status != 1) {
            return response()->json([
                'message' => '审批结果错误',
            ], 400);
        }

        if ($request->status == 1 && $consumable_application->consumable->number < $consumable_application->number) {
            return response()->json([
                'message' => '数量不够',
            ], 400);
        }

        $consumable_application->status = $request->status;
        $consumable_application->description = $request->description;
        $consumable_application->save();
        $consumable_application->updateConsumable();

        return response()->json([
            'consumable_application' => $consumable_application,
        ]);
    }

    public function destroy($id)
    {
        $consumable_application = ConsumableApplication::where('id', $id)->where('status', 0)->firstOrFail();
        if ($consumable_application->user_id != UserMid::$user->id && !UserMid::$user->isGroupLeader($consumable_application->group_id)) {
            return response()->json([
                'message' => '需要负责人或者本组组长执行操作',
            ], 403);
        }

        $consumable_application->revertConsumable();
        $consumable_application->delete();

        return response('', 204);
    }
}
