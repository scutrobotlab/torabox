<?php

namespace App\Http\Controllers;

use App\Http\Middleware\UserMid;
use App\Models\Consumable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\ConsumableForm;

class ConsumableController extends Controller
{
    public function list()
    {
        return response()->json([
            'consumables' => Consumable::all(),
        ]);
    }

    public function store(ConsumableForm $request)
    {
        $consumable = new Consumable();
        $consumable->uuid = Str::uuid();
        $consumable->name = $request->name;
        $consumable->user_id = UserMid::$user->id;
        $consumable->group_id = $request->group_id;
        $consumable->need_approval = $request->need_approval;
        $consumable->description = $request->description;
        $consumable->save();

        return response()->json([
            'consumable' => $consumable,
        ]);
    }

    public function index($id)
    {
        $consumable = Consumable::findOrFail($id);
        $consumable->group;
        $consumable->user;

        return response()->json([
            'consumable' => $consumable,
        ]);
    }

    public function indexApplications($id)
    {
        $consumable = Consumable::findOrFail($id);
        $consumable->applications->load(['applicant', 'approver']);

        return response()->json([
            'consumable' => $consumable,
        ]);
    }

    public function indexPurchases($id)
    {
        $consumable = Consumable::findOrFail($id);
        $consumable->purchases->load('user');

        return response()->json([
            'consumable' => $consumable,
        ]);
    }


    public function indexApprovers($id)
    {
        $consumable = Consumable::findOrFail($id);
        $consumable->approvers;

        return response()->json([
            'consumable' => $consumable,
        ]);
    }

    public function edit($id)
    {
        $consumable = Consumable::findOrFail($id);

        return response()->json([
            'access' => $consumable->user_id == UserMid::$user->id || UserMid::$user->isGroupLeader($consumable->group_id),
        ]);
    }

    public function update($id, Request $request)
    {
        $consumable = Consumable::findOrFail($id);
        if ($consumable->user_id != UserMid::$user->id && !UserMid::$user->isGroupLeader($consumable->group_id)) {
            return response()->json([
                'message' => '需要负责人或者本组组长执行操作',
            ], 403);
        }

        $consumable->name = $request->name;
        $consumable->description = $request->description;
        $consumable->save();

        return response()->json([
            'consumable' => $consumable,
        ]);
    }

    public function destroy($id)
    {
        $consumable = Consumable::findOrFail($id);
        if ($consumable->user_id != UserMid::$user->id && !UserMid::$user->isGroupLeader($consumable->group_id)) {
            return response()->json([
                'message' => '需要负责人或者本组组长执行操作',
            ], 403);
        }

        $consumable->applications()->delete();
        $consumable->purchases()->delete();
        $consumable->delete();

        return response('', 204);
    }
}
