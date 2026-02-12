<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Auth;

class RazorpayController extends Controller
{
    // Show payment page (optional)
    public function index()
    {
        return view('razorpay.index');
    }

    // Create Razorpay order
    public function payment(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $amount = $request->amount * 100; // convert to paise
        $order  = $api->order->create([
            'receipt'         => 'order_' . time(),
            'amount'          => $amount,
            'currency'        => 'INR',
            'payment_capture' => 1,
        ]);

        return response()->json([
            'order_id' => $order['id'],
            'amount'   => $order['amount'],
        ]);
    }

    // Handle payment success
    public function success(Request $request)
    {
        // Optional: Verify payment signature if needed

        // You can save order details to DB here
        // Example:
        // Order::create([
        //     'user_id' => Auth::id(),
        //     'product_name' => $request->name,
        //     'amount' => $request->amount,
        //     'payment_id' => $request->razorpay_payment_id,
        // ]);

        return redirect()->route('dashboard')
            ->with('success', 'Your payment for ' . $request->name . ' of ₹' . $request->amount . ' was successful!');
    }
}
