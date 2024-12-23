<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function checkoutOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
            'phone' => 'numeric|required|digits_between:10,13',
            'address' => 'string|required',
            'payment_method' => 'required'
        ], [
            'payment_method.required' => 'Please select payment method'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $input = $request->all();
        // dd($input);
        $order_number = 'ORD-' . strtoupper(Str::random(10));
        $input['user_id'] = Auth::id();
        $input['order_number'] = $order_number;
        $input['total_amount'] = Cart::cartAmount(Auth::id());
        $input['quantity'] = Cart::countCartProduct(Auth::id());

        $cart = Cart::getCartsBeforeOrder(Auth::id());

        $params = array(
            'transaction_details' => array(
                'order_id' => $order_number,
                'gross_amount' => $input['total_amount'],
            ),
            'customer_details' => array(
                'first_name' => $input['name'],
                'phone' => $input['phone'],
                'address' => $input['address']
            )
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $input['snap_token'] = $snapToken;
        // dd($input['payment_method']);

        if ($input['payment_method'] === 'midtrans') {
            $cart = Cart::getCartsBeforeOrder(Auth::id());
            $cart->each(function ($item) use ($order_number, $snapToken) {
                $item->update([
                    'order_number' => $order_number,
                    'snap_token' => $snapToken,
                    'status' => 'payment'
                ]);
            });
        } else if ($input['payment_method'] === 'cod') {
            $cart = Cart::getCartsBeforeOrder(Auth::id());
            $cart->each(function ($item) use ($order_number) {
                $item->update([
                    'order_number' => $order_number,
                    'status' => 'payment'
                ]);
            });
        } else {
            Session::flash('error', 'Invalid payment method.');
            return back();
        };
        Order::create($input);

        return redirect("payment/{$input['order_number']}");
    }

    public function handleCallback(Request $request)
    {
        $serverKey = env("MIDTRANS_SERVER_KEY");
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        if ($hashed == $request->signature_key) {
            $order = Order::where('order_number', $request->order_id);
            $cart = Cart::where('order_number', $request->order_id);
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                if ($order) {
                    // $order->update(['payment_status' => 'paid']);
                    $cart->each(function ($cartItem) {
                        $cartItem->update(['status' => 'success', 'payment_status' => 'paid']);

                        // Update product stock
                        $product = Product::find($cartItem->product_id);
                        if ($product) {
                            $newStock = $product->stock - $cartItem->quantity;
                            $product->update(['stock' => $newStock]);
                        }
                    });
                    return response()->json(['message' => 'success'], 200);
                } else {
                    return response()->json(['message' => 'Order not found'], 404);
                }
            }
            if ($request->transaction_status == 'expire') {
                // $order->update(['payment_status' => 'cancel']);
                $cart->update(['status' => 'cancel', 'payment_status' => 'cancel']);
            } else {
                return response()->json(['message' => 'Order not found'], 404);
            }
        }
    }



    public function checkoutSuccess()
    {
        return view('frontend.payments.payment-success');
    }


    public function trackOrder()
    {
        $orders = Order::getUserOrders(Auth::id());
        return view('frontend.orders.order-track', compact('orders'));
    }

    public function trackOrderDetail($order_number)
    {
        $order = Order::singleOrder($order_number);
        $carts = Cart::getUserCartDetail(Auth::id(), $order_number);
        return view('frontend.orders.order-track-detail', compact('order', 'carts'));
    }


    /**
     * Display a listing of the resource.
     */
    public function orderLists()
    {
        $orders = Order::orderLists(Auth::id());
        return view('backend.orders.index', compact('orders'));
    }

    public function orderDetail($order_number)
    {
        $order = Order::where('order_number', $order_number)->first();
        // dd($order->payment_status);

        $carts = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select('carts.*', 'products.product_name')
            ->where('products.user_id', Auth::id())
            ->where('order_number', $order_number)
            ->get();
        // $carts = Cart::productOrderDetail(Auth::id(), $order_number);
        // dd($carts);
        $total = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select(DB::raw('SUM(carts.amount) as total_amount'))
            ->where('products.user_id', Auth::id())
            ->where('order_number', $order_number)
            ->groupBy('carts.order_number')
            ->first();
        // dd($total);
        $status_opt = ['new' => 'New', 'process' => 'Process', 'delivered' => 'Delivered', 'cancel' => 'Cancel'];
        $cart = Cart::where('order_number', $order_number)->first();
        // dd($cart);

        if (!$order) {
            abort(404);
        }

        return view('backend.orders.detail', compact('order', 'carts', 'cart', 'total', 'status_opt'));
    }

    public function singleProcess(Request $request, $order_number)
    {
        // dd($request->all());
        $order = Order::singleOrder($order_number);
        $cart = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->join('brands', 'carts.brand_id', '=', 'brands.id')
            ->where('products.user_id', Auth::id())
            ->where('brands.user_id', Auth::id())
            ->where('order_number', $order_number);

        if ($order->payment_method === 'midtrans') {
            $cart->update(['order_status' => $request->order_status]);
        } else if ($order->payment_method === 'cod') {
            $cart->update(['order_status' => $request->order_status, 'payment_status' => $request->payment_status]);
        }

        return redirect(route('order-lists'));
    }

    public function processAll(Request $request)
    {
        $selectedOrders = $request->input('selected_orders');

        if (!$selectedOrders) {
            Session::flash('error', 'Please select at least 1');
            return back();
        }
        // dd($selectedOrders);
        foreach ($selectedOrders as $orderNumber) {
            $cart = Cart::where('order_number', $orderNumber)->first();
            if ($cart->order_status === 'new') {
                if ($cart) {
                    $cart->update([
                        'order_status' => 'process'
                    ]);
                }
            }
        }

        return back();
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
