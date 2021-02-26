<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function setupIntents()
    {
$user_id = auth()->user()->id;
// $user_id = 1;
        // $del = User::find($user_id)->paymentMethods()->map(function($paymentMethod) {
        //     $paymentMethod->delete();
        //     // return $paymentMethod;
        // });
        //         $apiKey = env('STRIPE_KEY');
        // $str = Stripe::setApiKey($apiKey);

        $intent = User::find($user_id)->createSetupIntent();
// dd($intent);
        return view('stripe.setup-intents-three', compact('intent'));
        // return view('stripe.setup-intents', compact('intent'));
    }

    public function subscribe(Request $request)
    {
        // dd($request->all());
        $user_id = 1;
        $user_id = auth()->user()->id;

        // $apiKey = env('STRIPE_KEY');
        // $str = Stripe::setApiKey($apiKey);


        $payment_method = $request->payment_method ?? '';
        $plan = $request->plan ?? '';
        $stripe_token = $request->stripe_token ?? '';

        try {
            // $cust = 'cus_J11ipaSHWXvS7H';
            // $user = User::find(1)->newSubscription(
            //     'hashtag', $plan
            // )->create($payment_method);
            $user = User::find($user_id)->newSubscription(
                'cashier', $plan
            )->create($payment_method);
            // $options = [
            //     'currency' => 'inr',
            // ];
            // $user = User::find(1)->charge(
            //     888, $payment_method, $options
            // );


            // )->create($stripe_token);
            
            // dd($user);
            return json_encode([$user]);
        } catch (\Exception $e) {
            
            return $e->getMessage().'*';
        }


    }
}
