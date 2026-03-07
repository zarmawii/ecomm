<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Product;

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
        $order = $api->order->create([
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
        $payment = Payment::where('order_id', $request->razorpay_order_id)->first();

        if (!$payment) {
            return redirect()->route('dashboard')
                ->with('error', 'Payment not found.');
        }

        // Create order from cart/session
        foreach (session('cart', []) as $productId => $item) {

            $product = Product::find($productId);

            if ($product) {
                Order::create([
                    'user_id' => Auth::id(),
                    'seller_id' => $product->seller_id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'total_price' => $item['price'] * $item['quantity'],
                    'payment_status' => 'paid',
                    'order_status' => 'pending',
                ]);
            }
        }

        // Mark payment success
        $payment->status = 1;
        $payment->save();

        // Clear cart after order
        session()->forget('cart');

        return redirect()->route('dashboard')
            ->with('success', 'Order placed successfully!');
    }
}