<?php

namespace App\Http\Controllers;

use App\Http\Middleware\UserMid;
use App\Models\Immovable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\ImmovableForm;

class ImmovableController extends Controller
{
    public function list()
    {
        return response()->json([
            'immovables' => Immovable::all(),
        ]);
    }

    public function store(ImmovableForm $request)
    {
        $immovable = new Immovable();
        $immovable->uuid = Str::uuid();
        $immovable->name = $request->name;
        $immovable->immovable_kind_id = $request->immovable_kind_id;
        $immovable->user_id = UserMid::$user->id;
        $immovable->need_approval = $request->need_approval;
        $immovable->description = $request->description;
        $immovable->save();

        return response()->json([
            'immovable' => $immovable,
        ]);
    }

    public function index($id)
    {
        $immovable = Immovable::findIdorUuid($id);
        $immovable->kind;
        $immovable->group;
        $immovable->user;
        $immovable->owner;

        return response()->json([
            'immovable' => $immovable,
        ]);
    }

    public function indexApplications($id)
    {
        $immovable = Immovable::findIdorUuid($id);
        $immovable->applications->load(['applicant', 'approver']);

        return response()->json([
            'immovable' => $immovable,
        ]);
    }

    public function indexApprovers($id)
    {
        $immovable = Immovable::findIdorUuid($id);
        $immovable->approvers;

        return response()->json([
            'immovable' => $immovable,
        ]);
    }

    public function edit($id)
    {
        $immovable = Immovable::findIdorUuid($id);

        return response()->json([
            'access' => $immovable->user_id == UserMid::$user->id || UserMid::$user->isGroupLeader($immovable->group->id),
        ]);
    }

    public function update($id, Request $request)
    {
        $immovable = Immovable::findIdorUuid($id);
        if ($immovable->user_id != UserMid::$user->id && !UserMid::$user->isGroupLeader($immovable->group->id)) {
            return response()->json([
                'message' => '需要负责人或者本组组长执行操作',
            ], 403);
        }

        $immovable->name = $request->name;
        if ($immovable->status == 0 || $immovable->status == -1) {
            $immovable->status = $request->status;
        }
        $immovable->description = $request->description;
        $immovable->save();

        return response()->json([
            'immovable' => $immovable,
        ]);
    }

    public function destroy($id)
    {
        $immovable = Immovable::findIdorUuid($id);
        if ($immovable->user_id != UserMid::$user->id && !UserMid::$user->isGroupLeader($immovable->group->id)) {
            return response()->json([
                'message' => '需要负责人或者本组组长执行操作',
            ], 403);
        }

        $immovable->applications()->delete();
        $immovable->delete();

        return response('', 204);
    }
}
