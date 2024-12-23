<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Profile;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use function Laravel\Prompts\error;

class CartController extends Controller
{
    protected $product = null;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function addToCart(Request $request)
    {

        if (empty($request->slug)) {
            Session::flash('error', 'Invalid Products');
            return back();
        }
        $product = Product::where('slug', $request->slug)->first();
        // dd($product->brand_id);
        // return $product;
        if (empty($product)) {
            Session::flash('error', 'Invalid Products');
            return back();
        }

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_number', null)->where('product_id', $product->id)->first();
        // return $already_cart;
        if ($already_cart) {
            // dd($already_cart);
            if ($already_cart->products->discount) {
                $already_cart->quantity = $already_cart->quantity + 1;
                $already_cart->amount = $product->price - ($product->price * $product->discount) / 100 + $already_cart->amount;
            } else {
                $already_cart->quantity = $already_cart->quantity + 1;
                $already_cart->amount = $product->price + $already_cart->amount;
            }

            // return $already_cart->quantity;
            if ($already_cart->products->stock < $already_cart->quantity || $already_cart->products->stock <= 0) return back()->with('error', 'Stock not sufficient!.');
            $already_cart->save();
        } else {

            $cart = new Cart;
            $cart->user_id = Auth::id();
            $cart->brand_id = $product->brand_id;
            $cart->product_id = $product->id;
            $cart->price = ($product->price - ($product->price * $product->discount) / 100);
            $cart->quantity = 1;
            $cart->amount = $cart->price * $cart->quantity;
            if ($cart->products->stock < $cart->quantity || $cart->products->stock <= 0) return back()->with('error', 'Stock not sufficient!.');
            $cart->save();
            // $wishlist = Wishlist::where('user_id', auth()->user()->id)->where('cart_id', null)->update(['cart_id' => $cart->id]);
        }
        Session::flash('success', 'Product successfully added to cart');
        return back();
    }

    public function singleAddToCart(Request $request)
    {
        $request->validate([
            'slug'      =>  'required',
            'quant'      =>  'required',
        ]);
        // dd($request->quant[1]);


        $product = Product::where('slug', $request->slug)->first();
        if ($product->stock < $request->quant[1]) {
            return back()->with('error', 'Out of stock, You can add other products.');
        }
        if (($request->quant[1] < 1) || empty($product)) {
            Session::flash('error', 'Invalid Products');
            return back();
        }

        $already_cart = Cart::where('user_id', Auth::id())->where('order_number', null)->where('product_id', $product->id)->first();

        // return $already_cart;

        if ($already_cart) {
            if ($already_cart->products->discount) {
                $already_cart->quantity = $already_cart->quantity + $request->quant[1];
                $already_cart->amount = ($product->price - ($product->price * $product->discount) / 100) * $request->quant[1] + $already_cart->amount;
            } else {
                $already_cart->quantity = $already_cart->quantity + $request->quant[1];
                $already_cart->amount = ($product->price * $request->quant[1]) + $already_cart->amount;
            }

            if ($already_cart->products->stock < $already_cart->quantity || $already_cart->products->stock <= 0) return back()->with('error', 'Stock not sufficient!.');
            // dd($already_cart);
            $already_cart->save();
        } else {

            $cart = new Cart;
            $cart->user_id = Auth::id();
            $cart->product_id = $product->id;
            $cart->brand_id = $product->brand_id;

            if ($cart->products->discount) {
                $cart->price = ($product->price - ($product->price * $product->discount) / 100);
                $cart->quantity = $request->quant[1];
                $cart->amount = ($product->price - ($product->price * $product->discount) / 100) * $request->quant[1];
            } else {
                $cart->price = $product->price;
                $cart->quantity = $request->quant[1];
                $cart->amount = $product->price * $request->quant[1];
            }
            if ($cart->products->stock < $cart->quantity || $cart->products->stock <= 0) return back()->with('error', 'Stock not sufficient!.');
            // dd($cart);
            $cart->save();
        }
        Session::flash('success', 'Product successfully added to cart.');
        return back();
    }

    public function cartUpdate(Request $request)
    {
        // dd($request->all());
        if ($request->quant) {
            $error = array();
            $success = '';
            // return $request->quant;
            foreach ($request->quant as $k => $quant) {
                // return $k;
                $id = $request->qty_id[$k];
                // return $id;
                $cart = Cart::find($id);
                // return $cart;
                if ($quant > 0 && $cart) {
                    // return $quant;

                    if ($cart->products->stock < $quant) {
                        Session::flash('error', 'Out of stock');
                        return back();
                    }
                    $cart->quantity = ($cart->products->stock > $quant) ? $quant  : $cart->products->stock;
                    // return $cart;

                    if ($cart->products->stock <= 0) continue;
                    $after_price = ($cart->products->price - ($cart->products->price * $cart->products->discount) / 100);
                    $cart->amount = $after_price * $quant;
                    // return $cart->price;
                    $cart->save();
                    $success = 'Cart successfully updated!';
                } else {
                    $error[] = 'Cart Invalid!';
                }
            }
            return back()->with($error)->with('success', $success);
        } else {
            return back()->with('Cart Invalid!');
        }
    }

    public function cartDelete(Request $request)
    {
        $cart = Cart::find($request->id);
        if ($cart) {
            $cart->delete();
            Session::flash('success', 'Cart successfully removed');
            return back();
        }
        Session::flash('error', 'Error please try again');
        return back();
    }

    public function Checkout(Request $request)
    {

        $total_price = Cart::totalPriceCheckout();
        $profile = Profile::getUserName(Auth::id());
        if ($total_price <= 0) {
            abort(404);
        }

        return view('frontend.cart.checkout', compact('total_price', 'profile'));
    }

    public function checkoutPay($order_number)
    {
        $cart = Cart::getCartPayment($order_number);

        if ($cart->status !== 'payment') {
            abort(404);
        }

        $order = Order::orderPayment($order_number);
        $total_price = Cart::where('order_number', $order_number)->sum('amount');
        return view('frontend.payments.payment', compact('cart', 'order', 'total_price'));
    }

    public function checkoutCod($order_number)
    {

        $cart = Cart::getCartPayment($order_number);

        if ($cart->status !== 'payment') {
            abort(404);
        }

        $cart->each(function ($cartItem) {
            $cartItem->update([
                'status' => 'success'
            ]);

            $product = Product::find($cartItem->product_id);
            if ($product) {
                $newStock = $product->stock - $cartItem->quantity;
                $product->update(['stock' => $newStock]);
            } else {
                return redirect(route('home'))->with('error', 'Invalid stock');
            }
        });


        return redirect(route('payment-success', ['order_number' => $order_number]));
    }


    public function paymentSuccess($order_number)
    {
        $order = Cart::where('order_number', $order_number)->where('status', 'success')->firstOrFail();

        return view('frontend.payments.payment-success', compact('order'));
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Cart::getCartProducts(Auth::id());
        // dd($carts);
        $cart_count = Cart::countCartProduct(Auth::id());
        return view('frontend.cart.cart', compact('carts'));
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
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
