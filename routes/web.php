<?php

use App\Http\Controllers\StripeController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Psy\CodeCleaner\UseStatementPass;
use Stripe\Stripe;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


Route::get('subscription/setup-intents', [StripeController::class, 'setupIntents']);

Route::post('subscription/subscribe', [StripeController::class, 'subscribe'])->name('subscription.subscribe');


Route::get("/test-test", function() {
  
    $apiKey = env('STRIPE_KEY');
    $str = Stripe::setApiKey($apiKey);  


    
    try {
        $options = [
            'currency' => 'inr'
        ];

        return App\Models\User::find(6)->downloadInvoice('in_1IPhKsFv5ObAscf6nZgLHyXj', [
            'vendor' => 'vendor Gowtham',
            'product' => 'laravel product Gowtham',
            ], 'mera-invoice-hai');

        // $user = User::find(auth()->user()->id)->createAsStripeCustomer();

        // $user = User::find(auth()->user()->id)->newSubscription('tshirt', 'price_1IPhNcFv5ObAscf6X21PoW6H')->add();
        // $userBefore = User::find(1)->paymentMethods();

        // deltes payment methods
        // $del = User::find(1)->paymentMethods()->map(function($paymentMethod) {
        //     $paymentMethod->delete();
        // });

        // $userAfter = User::find(1)->paymentMethods();

        // dd($user);
    } catch (\Exception $e) {
        
        dd($e->getMessage());
    }


});


Route::get('test', function() {
    // create stripe customer

    $apiKey = env('STRIPE_KEY');
    $str = Stripe::setApiKey($apiKey);

    try {
        $options = [
            'currency' => 'inr'
        ];
        $user = User::find(auth()->user()->id)->createAsStripeCustomer();
        // $userBefore = User::find(1)->paymentMethods();

        // deltes payment methods
        // $del = User::find(1)->paymentMethods()->map(function($paymentMethod) {
        //     $paymentMethod->delete();
        // });

        // $userAfter = User::find(1)->paymentMethods();

        dd($user);
    } catch (\Exception $e) {
        
        dd($e->getMessage());
    }


    
    // dd($user);
});




