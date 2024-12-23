<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_name',
        'slug',
        'status',
        'summary',
        'img'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'cat_id');
    }

    //

    public static function getAllCategory()
    {
        return Categories::join('users', 'categories.user_id', '=', 'users.id')
            ->select('categories.*', 'users.name as username')
            ->orderBy('categories.id', 'DESC')
            ->paginate(10);
    }

    public static function getCategoryProduct()
    {
    }
    public static function getCategoryBySlug($slug)
    {
        return Categories::where('slug', $slug)->first();
    }

    public static function getProductByCat($slug)
    {
        return Categories::with('products')->where('slug', $slug)->first();
    }

    public static function getCategoryStatusTrue()
    {
        return Categories::where('status', true)->orderBy('category_name', 'ASC')->get();
    }
}
