<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function Laravel\Prompts\select;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'brand_id',
        'cat_id',
        'product_name',
        'slug',
        'img',
        'description',
        'price',
        'size',
        'stock',
        'status',
        'discount',
        'condition'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function categories()
    {
        return $this->belongsTo(Categories::class, 'cat_id');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }

    //

    public static function allProduct($id)
    {
        return Product::where('user_id', $id);
    }

    //

    public static function getAllProducts()
    {
        return Product::join('users', 'products.user_id', '=', 'users.id')
            ->select('products.*', 'users.name as username')
            ->orderBy('products.id', 'DESC')
            ->paginate(10);
    }

    public static function getProducts()
    {
        return Product::orderBy('products.id', 'DESC')->paginate(10);
    }

    public static function getProductStatusTrue()
    {
        return Product::where('status', true)->get();
    }

    public static function getProductBackend($user_id)
    {
        return Product::with(['user:id,name', 'brand:id,brand_name', 'categories:id,category_name'])
            ->where('user_id', $user_id)
            ->orderBy('id', 'Desc')
            ->paginate(10);
    }

    public static function getProductBySlug($slug)
    {
        return Product::with(['brand:id,brand_name', 'categories:id,category_name'])
            ->where('slug', $slug)
            ->first();
    }

    public static function getRelatedProducts($cat_id, $product_id)
    {
        return Product::with(['brand:id,brand_name', 'categories:id,category_name'])
            ->where('cat_id', $cat_id)
            ->where('id', '!=', $product_id)
            ->get();
    }

    public static function getProductByCat($slug)
    {
        return Product::with('categories')
            ->whereHas('categories', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })
            ->orderBy('id', 'DESC')
            ->paginate(6);
    }

    public static function getProductByBrand($slug)
    {
        return Product::with('brand')
            ->whereHas('brand', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })
            ->orderBy('id', 'DESC')
            ->paginate(6);
    }

    public static function getRecentProducts()
    {
        return Product::where('status', true)->orderBy('id', 'DESC')->limit(3)->get();
    }

    public static function productSearch($search)
    {
        return Product::orwhere('product_name', 'like', '%' . $search . '%')
            ->orwhere('slug', 'like', '%' . $search . '%')
            ->orwhere('description', 'like', '%' . $search . '%')
            ->orwhere('price', 'like', '%' . $search . '%')
            ->orderBy('id', 'DESC')
            ->paginate('9');
    }

    public static function getProductWithCondition($slug)
    {
        return Product::where('slug', $slug);
    }

    public static function latestItem()
    {
        return Product::where('status', true)->orderBy('updated_at', 'DESC')->limit(6)->get();
    }

    public static function singleDelete($user_id, $slug)
    {
        return Product::where('user_id', $user_id)->where('slug', $slug)->first();
    }

    public static function getAllProductsAdmin()
    {
        return Product::with('user:id,username')->orderByDesc('created_at')->paginate(10);
    }

    public static function productUserAssign()
    {
        return User::whereIn('role', ['admin', 'seller'])->where('status', true)->get();
    }
}
