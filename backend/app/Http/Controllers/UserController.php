<?php

namespace App\Http\Controllers;

use App\Http\Middleware\UserMid;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        if (!$request->has('code')) {
            return response()->json([
                'message' => 'Failed',
            ], 400);
        }

        $resp = User::newOauthUserinfo($request->code);
        if (!$resp['success']) {
            return response()->json([
                'message' => $resp['message'],
            ], 500);
        }
        $user = $resp['message'];

        session(['user' => $user]);
        return response()->json([
            'user' => $user,
        ]);
    }

    public function indexSelfNotificationCount()
    {
        return response()->json([
            'notification_count' => [
                'immovables_owned' => UserMid::$user->immovables_owned->count(),
                'immovable_applications_applied' => UserMid::$user->immovable_applications_applied_pending->count(),
                'immovable_applications_approved' => UserMid::$user->immovable_applications_approved_pending->count(),
                'consumable_applications_applied' => UserMid::$user->consumable_applications_applied_pending->count(),
                'consumable_applications_approved' => UserMid::$user->consumable_applications_approved_pending->count(),
            ],
        ]);
    }

    public function indexSelfImmovablesOwned()
    {
        return response()->json([
            'immovables' => UserMid::$user->immovables_owned,
        ]);
    }

    public function indexSelfImmovableApplicationsApplied(Request $request)
    {
        $immovables_applications = null;
        if ($request->pending) {
            $immovables_applications = UserMid::$user->immovable_applications_applied_pending;
        } else {
            $immovables_applications = UserMid::$user->immovable_applications_applied;
        }

        return response()->json([
            'immovable_applications' => $immovables_applications->load(['immovable', 'applicant', 'approver']),
        ]);
    }

    public function indexSelfImmovableApplicationsApproved(Request $request)
    {
        $immovables_applications = null;
        if ($request->pending) {
            $immovables_applications = UserMid::$user->immovable_applications_approved_pending;
        } else {
            $immovables_applications = UserMid::$user->immovable_applications_approved;
        }

        return response()->json([
            'immovable_applications' => $immovables_applications->load(['immovable', 'applicant', 'approver']),
        ]);
    }

    public function indexSelfConsumableApplicationsApplied(Request $request)
    {
        $consumable_applications = null;
        if ($request->pending) {
            $consumable_applications = UserMid::$user->consumable_applications_applied_pending;
        } else {
            $consumable_applications = UserMid::$user->consumable_applications_applied;
        }

        return response()->json([
            'consumable_applications' => $consumable_applications->load(['consumable', 'applicant', 'approver']),
        ]);
    }

    public function indexSelfConsumableApplicationsApproved(Request $request)
    {
        $consumable_applications = null;
        if ($request->pending) {
            $consumable_applications = UserMid::$user->consumable_applications_approved_pending;
        } else {
            $consumable_applications = UserMid::$user->consumable_applications_approved;
        }

        return response()->json([
            'consumable_applications' => $consumable_applications->load(['consumable', 'applicant', 'approver']),
        ]);
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

    public function updateSelf()
    {
        $uuid = UserMid::$user->uuid;
        $refresh_token = UserMid::$user->refresh_token;
        $resp = User::updateOauthUserinfo($uuid, $refresh_token);
        if (!$resp['success']) {
            return response()->json([
                'message' => $resp['message'],
            ], 500);
        }
        $user = $resp['message'];

        session(['user' => $user]);
        return response()->json([
            'user' => $user,
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
        $user = User::storeOauthUserinfo($json, Str::random(80));
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
