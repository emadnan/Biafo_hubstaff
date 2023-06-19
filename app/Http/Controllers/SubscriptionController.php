<?php

namespace App\Http\Controllers;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    public function addSubscription(Request $request)
    {
        $subscription = new Subscription;
        $subscription->name = $request->name;
        $subscription->type = $request->type;
        $subscription->no_of_cards = $request->no_of_cards;
        $subscription->amount = $request->amount;
        $subscription->use_username = $request->can_username;
        $subscription->save();
        return response()->json(['massage' => 'Add subscription successfully']);
    }
    public function deleteSubscription($id)
    {
        $subscription = Subscription::find($id);
        $subscription->delete();
        return response()->json(['massage' => 'Delete subscription successfully']);
    }
    public function updateSubscription($id,Request $request)
    {
        $subscription = Subscription::find($id);
        $subscription->name = $request->name;
        $subscription->type = $request->type;
        $subscription->no_of_cards = $request->no_of_cards;
        $subscription->amount = $request->amount;
        $subscription->use_username = $request->can_username;
        $subscription->save();
        return response()->json(['massage' => 'Update subscription successfully']);
    }

    public function getAllSubscription()
    {
        $subscriptions = Subscription::all();
        return response()->json(['subscriptions' => $subscriptions]);
    }
}
