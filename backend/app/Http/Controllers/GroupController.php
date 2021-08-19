<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{
    public function list()
    {
        return response()->json([
            'groups' => Group::all()
        ]);
    }

    public function index($id)
    {
        return response()->json([
            'groups' => Group::findOrFail($id),
        ]);
    }

    public function indexUserList($id)
    {
        return response()->json([
            'users' => Group::findOrFail($id)->users,
        ]);
    }

    public function indexMemberList($id)
    {
        return response()->json([
            'users' => Group::findOrFail($id)->members,
        ]);
    }

    public function indexLeaderList($id)
    {
        return response()->json([
            'users' => Group::findOrFail($id)->leaders,
        ]);
    }
}
