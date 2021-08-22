<?php

namespace App\Http\Controllers;

use App\Http\Middleware\UserMid;
use App\Models\ConsumablePurchase;
use Illuminate\Http\Request;
use App\Http\Requests\ConsumableRecordForm;

class ConsumablePurchaseController extends Controller
{
    public function list(Request $request)
    {
        return response()->json([
            'consumable_purchases' => ConsumablePurchase::all(),
        ]);
    }

    public function store(ConsumableRecordForm $request)
    {
        $consumable_purchase = new ConsumablePurchase();
        $consumable_purchase->consumable_id = $request->consumable_id;
        $consumable_purchase->user_id = UserMid::$user->id;
        $consumable_purchase->number = $request->number;
        $consumable_purchase->description = $request->description;
        $consumable_purchase->save();
        $consumable_purchase->updateConsumable();

        return response()->json([
            'consumable_purchase' => $consumable_purchase,
        ]);
    }

    public function index($id)
    {
        $consumable_purchase = ConsumablePurchase::findOrFail($id);
        $consumable_purchase->consumable;
        $consumable_purchase->user;
        return response()->json([
            'consumable_purchase' => $consumable_purchase,
        ]);
    }

    public function destroy($id)
    {
        $consumable_purchase = ConsumablePurchase::findOrFail($id);
        if ($consumable_purchase->user_id != UserMid::$user->id && !UserMid::$user->isGroupLeader($consumable_purchase->group_id)) {
            return response()->json([
                'message' => '需要负责人或者本组组长执行操作',
            ], 403);
        }

        if ($consumable_purchase->consumable->number < $consumable_purchase->number) {
            return response()->json([
                'message' => '数量不够',
            ], 400);
        }

        $consumable_purchase->revertConsumable();
        $consumable_purchase->delete();

        return response('', 204);
    }
}
