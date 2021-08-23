<?php

namespace App\Http\Controllers;

use App\Http\Middleware\UserMid;
use App\Models\ImmovableKind;
use Illuminate\Http\Request;
use App\Http\Requests\ImmovableKindForm;

class ImmovableKindController extends Controller
{
    public function list()
    {
        return response()->json([
            'immovable_kinds' => ImmovableKind::all()->load('group'),
        ]);
    }

    public function store(ImmovableKindForm $request)
    {
        $immovable_kind = new ImmovableKind();
        $immovable_kind->name = $request->name;
        $immovable_kind->group_id = $request->group_id;
        $immovable_kind->description = $request->description;
        $immovable_kind->save();

        return response()->json([
            'immovable_kind' => $immovable_kind,
        ]);
    }

    public function index($id)
    {
        return response()->json([
            'immovable_kind' => ImmovableKind::findOrFail($id)->load('group'),
        ]);
    }

    public function indexImmovableList($id)
    {
        return response()->json([
            'immovables' => ImmovableKind::findOrFail($id)->immovables,
        ]);
    }

    public function edit($id)
    {
        $immovable_kind = ImmovableKind::findOrFail($id);

        return response()->json([
            'access' => UserMid::$user->isGroupLeader($immovable_kind->group_id),
        ]);
    }

    public function destroy($id)
    {
        $immovable_kind = ImmovableKind::findOrFail($id);
        if (!UserMid::$user->isGroupLeader($immovable_kind->group_id)) {
            return response()->json([
                'message' => '需要本组组长执行操作',
            ], 403);
        }

        $immovable_kind->immovables()->delete();
        $immovable_kind->delete();

        return response('', 204);
    }
}
