<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'brand_name',
        'slug',
        'status'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'id')->where('status', true);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'brand_id');
    }
    //

    public static function getAllBrand()
    {
        // return Brand::join('users', 'brands.user_id', '=', 'users.id')
        //     ->select('brands.*', 'users.name as username')
        //     ->orderBy('brands.id', 'DESC')
        //     ->paginate(10);

        return Brand::with('user:id,name')->orderBy('brands.id', 'DESC')->paginate(10);
    }

    public static function getBrandProduct()
    {
        return Brand::join('products', 'brands.id', '=', 'products.brand_id')
            ->select('brands.id', 'brands.brand_name', 'products.*')
            ->orderBy('brands.id', 'DESC')
            ->paginate(10);
    }

    public static function getUserAssign()
    {
        return User::whereIn('role', ['admin', 'seller'])->where('status', true)->get();
    }

    public static function getBrandBySlug($slug)
    {
        return Brand::where('slug', $slug)->first();
    }

    public static function getBrandStatusTrue()
    {
        return Brand::where('status', true)->get();
    }

    public static function getProductByBrand($slug)
    {
        // dd($slug);
        return Brand::with('products')->where('slug', $slug)->first();
        // return Product::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    }
}
