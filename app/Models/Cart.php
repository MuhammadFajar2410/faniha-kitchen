<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'snap_token',
        'status',
        'order_status',
        'payment_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_number', 'order_number');
    }

    public static function getCartsBeforeOrder($user_id)
    {
        return Cart::where('user_id', $user_id)->where('order_number', null)->get();
    }
    public static function getCartPayment($order_number)
    {
        return Cart::where('order_number', $order_number)->first();
    }

    public static function getCartProducts($user_id)
    {
        return Cart::with('products')->where('user_id', $user_id)->where('order_number', null)->get();
    }

    public static function countCartProduct($user_id)
    {
        return Cart::with('products')->where('user_id', $user_id)->where('order_number', null)->count();
    }

    public static function cartAmount($user_id)
    {
        return Cart::where('user_id', $user_id)->where('order_number', null)->sum('amount');
    }

    public static function totalPriceCheckout()
    {
        return Cart::with('user')->whereNull('order_number')->sum('amount');
    }

    public static function productOrderDetail($order_number)
    {
        return Cart::with(['products:id,user_id,product_name'])->where('order_number', $order_number)->get();
    }

    public static function getUserCartDetail($user_id, $order_number)
    {
        return Cart::with(['products:id,product_name', 'brand:id,brand_name'])->where('user_id', $user_id)->where('order_number', $order_number)->orderBy('brand_id', 'ASC')->get();
    }
}
