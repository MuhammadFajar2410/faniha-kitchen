<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'quantity',
        'payment_method',
        'payment_status',
        'name',
        'phone',
        'address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'order_number', 'order_number');
    }

    public static function orderPayment($order_number)
    {
        return Order::where('order_number', $order_number)->first();
    }

    public static function orderLists($user_id)
    {
        return DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->join('brands', 'carts.brand_id', '=', 'brands.id')
            ->join('orders', 'carts.order_number', '=', 'orders.order_number')
            ->select('orders.name', 'orders.order_number', 'orders.phone', 'orders.address', 'orders.payment_method', 'carts.payment_status', 'carts.order_status', DB::raw('SUM(carts.amount) as total_amount'), 'products.user_id')
            ->where('products.user_id', $user_id)
            ->where('brands.user_id', $user_id)
            ->groupBy('orders.name', 'orders.order_number', 'products.user_id', 'orders.phone', 'orders.address', 'orders.payment_method', 'carts.payment_status', 'carts.order_status')
            ->orderBy('orders.created_at', 'DESC')
            ->paginate(10);
    }



    public static function singleOrder($order_number)
    {
        return Order::where('order_number', $order_number)->first();
    }

    public static function getUserOrders($user_id)
    {
        return Order::with('cart:order_number,status,payment_status,order_status')->paginate(10);
    }
}
