<?php

namespace App\Http\Controllers;

use App\Http\Middleware\UserMid;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function isLoggedIn(Request $request)
    {
        return response()->json([
            'success' => $request->session()->has('user'),
        ]);
    }

    public function login(Request $request)
    {
        if ($request->has('code')) {
            $resp = User::oauth($request->code);
            if ($resp['success']) {
                $user = User::storeOauth($resp['message']);
                session(['user' => $user]);
                return response()->json([
                    'user' => $user,
                ]);
            } else {
                return response()->json([
                    'message' => $resp['message'],
                ], 500);
            }
        }

        return response()->json([
            'message' => 'Failed',
        ], 400);
    }

    public function indexSelf()
    {
        return response()->json([
            'user' => UserMid::$user,
        ]);
    }

    public function index($id)
    {
        return response()->json([
            'user' => User::findOrFail($id),
        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return response('', 204);
    }

    public function fakeLogin(Request $request)
    {
        $users = User::fakeUsers();
        $id = $request->has('id') ? $request->id - 1 : 0;
        if ($id < 0 || $id > count($users)) {
            return response()->json([
                'message' => 'Not found',
            ], 404);
        }
        $json = User::fakeOauth($id);
        $user = User::storeOauth($json);
        session(['user' => $user]);
        return response()->json([
            'user' => $user,
        ]);
    }

    public function fakeIndex($id)
    {
        $users = User::fakeUsers();
        return response()->json([
            'user' => $users[$id],
        ]);
    }

    public function fakeList()
    {
        $users = User::fakeUsers();
        $res = [];
        foreach ($users as $user) {
            array_push($res, [
                'id' => $user['id'],
                'name' => $user['name'],
            ]);
        }
        return response()->json([
            'users' => $res,
        ]);
    }
}
