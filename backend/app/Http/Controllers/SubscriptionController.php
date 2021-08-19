<?php

namespace App\Http\Controllers;

use App\Http\Middleware\UserMid;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Http\Requests\SubscriptionForm;

class SubscriptionController extends Controller
{
    public function list(Request $request)
    {
        return response()->json([
            'subscriptions' => Subscription::all(),
        ]);
    }

    public function store(SubscriptionForm $request)
    {
        $subscription = new Subscription();
        $subscription->user_id = UserMid::$user->id;
        $subscription->group_id = $request->group_id;
        $subscription->name = $request->name;
        $subscription->end_time = $request->end_time;
        $subscription->description = $request->description;
        $subscription->save();

        return response()->json([
            'subscription' => $subscription,
        ]);
    }

    public function index($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->group;
        $subscription->user;
        return response()->json([
            'subscription' => $subscription,
        ]);
    }

    public function edit($id)
    {
        $subscription = Subscription::findOrFail($id);
        return response()->json([
            'access' => $subscription->user_id == UserMid::$user->id || UserMid::$user->isGroupLeader($subscription->group_id),
        ]);
    }

    public function update($id, SubscriptionForm $request)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->user_id = UserMid::$user->id;
        $subscription->group_id = $request->group_id;
        $subscription->name = $request->name;
        $subscription->end_time = $request->end_time;
        $subscription->description = $request->description;
        $subscription->save();

        return response()->json([
            'subscription' => $subscription,
        ]);
    }

    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);
        if ($subscription->user_id != UserMid::$user->id && !UserMid::$user->isGroupLeader($subscription->group_id)) {
            return response()->json([
                'message' => '需要负责人或者本组组长执行操作',
            ], 403);
        }

        $subscription->delete();

        return response('', 204);
    }
}
