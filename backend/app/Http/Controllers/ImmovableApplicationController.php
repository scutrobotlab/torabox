<?php

namespace App\Http\Controllers;

use App\Http\Middleware\UserMid;
use App\Models\Immovable;
use App\Models\ImmovableApplication;
use Illuminate\Http\Request;

class ImmovableApplicationController extends Controller
{
    public function list()
    {
        return response()->json([
            'immovable_applications' => ImmovableApplication::latest()->paginate()->load(['immovable', 'applicant', 'approver']),
        ]);
    }

    public function paginationLength()
    {
        return response()->json([
            'pagination_length' => ImmovableApplication::paginate()->lastPage(),
        ]);
    }

    public function store(Request $request)
    {
        $immovable = Immovable::findOrFail($request->immovable_id);
        $immovable_application = new ImmovableApplication();
        $immovable_application->immovable_id = $request->immovable_id;
        $immovable_application->applicant_id = UserMid::$user->id;

        if ($immovable->need_approval) {
            $immovable->approvers()->findOrFail($request->approver_id);
            $immovable_application->approver_id = $request->approver_id;
            $immovable_application->status = 0;
        } else {
            $immovable_application->status = 1;
        }

        $action = 'lend';
        if ($immovable->status == 0) {
            $action = 'lend';
        } else if ($immovable->status == 1 && $immovable->owner_id == UserMid::$user->id) {
            $action = 'return';
        } else {
            return response()->json([
                'message' => '操作错误',
            ], 403);
        }

        $immovable_application->action = $action;
        $immovable_application->description = $request->description;
        $immovable_application->save();
        $immovable_application->updateImmovable();

        return response()->json([
            'immovable_application' => $immovable_application,
        ]);
    }

    public function index($id)
    {
        $immovable_application = ImmovableApplication::findOrFail($id);
        $immovable_application->immovable;
        $immovable_application->applicant;
        $immovable_application->approver;
        return response()->json([
            'immovable_application' => $immovable_application,
        ]);
    }

    public function edit($id)
    {
        $immovable_application = ImmovableApplication::findOrFail($id);
        return response()->json([
            'access' => $immovable_application->approver_id == UserMid::$user->id,
        ]);
    }

    public function update($id, Request $request)
    {
        $immovable_application = ImmovableApplication::findOrFail($id);

        if ($immovable_application->approver_id != UserMid::$user->id) {
            return response()->json([
                'message' => '需要审批人执行操作',
            ], 403);
        }

        if ($immovable_application->status != 0) {
            return response()->json([
                'message' => '已审批',
            ], 400);
        }

        if ($request->status != -1 && $request->status != 1) {
            return response()->json([
                'message' => '审批结果错误',
            ], 400);
        }

        $immovable_application->status = $request->status;
        $immovable_application->description = $request->description;
        $immovable_application->save();
        $immovable_application->updateImmovable();

        return response()->json([
            'immovable_application' => $immovable_application,
        ]);
    }

    public function destroy($id)
    {
        $immovable_application = ImmovableApplication::where('id', $id)->where('status', 0)->firstOrFail();
        if ($immovable_application->user_id != UserMid::$user->id && !UserMid::$user->isGroupLeader($immovable_application->group->id)) {
            return response()->json([
                'message' => '需要负责人或者本组组长执行操作',
            ], 403);
        }

        $immovable_application->delete();

        return response('', 204);
    }
}
