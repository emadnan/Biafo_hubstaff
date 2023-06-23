<?php

namespace App\Http\Controllers;
use App\Models\Subscription;
use App\Models\SubscriptionInvoice;
use Carbon\Carbon;
use Stripe\Stripe;
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


    public function addSubscriptionInvoice(Request $request)
    {
        $subscription = new SubscriptionInvoice;
        $subscription->stripe_id = $request->stripe_id;
        $subscription->company_id = $request->company_id;
        $subscription->subscription_id = $request->subscription_id;
        $subscription->amount = $request->amount;
        $subscription->start_date = Carbon::today();
        if ($request->subscription_id == 1) {

            $subscription->end_date = null;
            
        }
        elseif ($request->subscription_id == 2) {

            $subscription->end_date = date('Y-m-d', strtotime('+1 month'));
        }
        elseif($request->subscription_id == 3) {

            $subscription->end_date = date('Y-m-d', strtotime('+1 year'));
        }
        $find=SubscriptionInvoice::where('company_id',$subscription->company_id)
        ->update([
            'is_active'=>'0'
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET_TEST'));
        Stripe::setApiKey(config('services.stripe.secret_test'));

        $payment = \Stripe\PaymentIntent::create([
            'amount' => $subscription->amount,
            'currency' => 'USD',
            'description' => 'WORKLOG',
            'payment_method' => $subscription->stripe_id,
            'confirm' => true
        ]);

        $subscription->save();

        return response()->json(['massage' => 'Add subscription invoice successfully']);
    }
   
    public function updateSubscriptionInvoice($id,Request $request)
    {
        $subscription = SubscriptionInvoice::find($id);
        $subscription->stripe_id = $request->stripe_id;
        $subscription->company_id = $request->company_id;
        $subscription->subscription_id = $request->subscription_id;
        $subscription->amount = $request->amount;
        $subscription->start_date = Carbon::today();
        if ($request->subscription_id == 1) {

            $subscription->end_date = null;
            
        }
        elseif ($request->subscription_id == 2) {

            $subscription->end_date = date('Y-m-d', strtotime('+1 month'));
        }
        elseif($request->subscription_id == 3) {

            $subscription->end_date = date('Y-m-d', strtotime('+1 year'));;
        }
        $find=SubscriptionInvoice::where('company_id',$subscription->company_id)
        ->update([
            'is_active'=>'0'
        ]);
        $subscription->save();
        return response()->json(['massage' => 'Update subscription invoice successfully']);
    }

    public function deleteSubscriptionInvoice($id)
    {
        $subscription = SubscriptionInvoice::find($id);
        $subscription->delete();
        
        return response()->json(['massage' => 'Delete subscription invoice successfully']);
    }

    public function getAllSubscriptionInvoice()
    {
        $subscriptions = SubscriptionInvoice::all();
        
        return response()->json(['subscriptions' => $subscriptions]);
    }
}
