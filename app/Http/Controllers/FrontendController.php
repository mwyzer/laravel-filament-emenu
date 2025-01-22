<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;

class FrontendController extends Controller
{
    //
    public function index(Request $request)
    {
        $store = User::where('username', $request->username)->first();

        if (!$store) {
            abort(404);
        }

        $categories = $store->productCategories;

        $products = Product::where('user_id', $store->id)->get();

        if (isset($request->search)) {
            $products = $products->where('name', 'like', '%' . $request->search . '%');
        }

        return view('index', compact('store', 'categories', 'products'));
    }

    public function cart(Request $request)
    {
        $store = User::where('username', $request->username)->first();

        if (!$store) {
            abort(404);
        }

        $categories = $store->productCategories;

        $products = Product::where('user_id', $store->id)->get();

        if (isset($request->search)) {
            $products = $products->where('name', 'like', '%' . $request->search . '%');
        }

        return view('cart', compact('store', 'categories', 'products'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'cart' => 'required|json',
            'name' => 'required|string',
            'payment_method' => 'required|string|in:cash,midtrans',
        ]);

        $store = User::where('username', $request->username)->first();

        if (!$store) {
            abort(404);
        }

        $cart = json_decode($request->cart, true);

        $total_price = 0;

        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            $total_price += $product->price * $item['quantity'];
        }

        $transaction = $store->transactions()->create([
            'code' => 'TRX- ' . mt_rand(10000, 99999),
            'name' => $request->name,
            'payment_method' => $request->payment_method,
            'total_price' => $total_price,
            'status' => 'pending',
        ]);

        foreach ($cart as $item) {
            $product = Product::where('id', $item['id'])->first();
            $transaction->transactionDetails()->create([
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'note' => $item['note'],
            ]);
        }

        if ($request->payment_method == 'cash') {
            return redirect()->route('success', ['username' => $store->username, 'order_id' => $transaction->code]);
        } else
        {
            //Set your Merchant Server Key
            \Midtrans\Config::$serverKey = config('midtrans.serverKey');

            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = config('midtrans.isProduction');

            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');

            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $transaction->code,
                    'gross_amount' => $total_price,
                ],
                'customer_details' => [
                    'first_name' => $request->name,
                    'phone' => $store->phone,
                ],
            ];
            
            $paymentUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;

            return redirect($paymentUrl);
        }
    }

    public function success(Request $request)
    {
        $transaction = Transaction::where('code', $request->order_id)->first();
        $store = User::where('username', $request->username)->first();

        if (!$store) {
            abort(404);
        }

        $order = $store->transactions()->where('code', $request->order_id)->first();

        if (!$order) {
            abort(404);
        }



        return view('success', compact('store', 'transaction'));
    }
}
