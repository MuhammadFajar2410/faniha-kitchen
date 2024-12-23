<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Cart;
use App\Models\Categories;
use App\Models\Product;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{
    public function home()
    {
        $categories = Categories::getCategoryStatusTrue();
        $products = Product::getProductStatusTrue();
        $latestProduct = Product::latestItem();
        return view('index', compact('categories', 'products', 'latestProduct'));
    }


    // Products

    public function productSearch(Request $request)
    {
        $recent_products = Product::getRecentProducts();
        $products = Product::productSearch($request->search);
        $categories = Categories::getCategoryStatusTrue();
        return view('frontend.products.product-grids', compact('recent_products', 'products', 'categories'));
    }

    public function productGrids()
    {
        $products = Product::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = Categories::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $products->whereIn('cat_id', $cat_ids);
            // return $products;
        }
        if (!empty($_GET['brand'])) {
            $slugs = explode(',', $_GET['brand']);
            $brand_ids = Brand::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
            return $brand_ids;
            $products->whereIn('brand_id', $brand_ids);
        }
        if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'product_name') {
                $products = $products->where('status', true)->orderBy('product_name', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $products = $products->orderBy('price', 'ASC');
            }
        }

        if (!empty($_GET['price'])) {
            $price = explode('-', $_GET['price']);
            // return $price;
            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));

            $products->whereBetween('price', $price);
        }

        $recent_products = Product::getRecentProducts();
        // Sort by number
        if (!empty($_GET['show'])) {
            $products = $products->where('status', true)->paginate($_GET['show']);
        } else {
            $products = $products->where('status', true)->paginate(9);
        }
        // Sort by name , price, category

        $categories = Categories::getCategoryStatusTrue();

        $user_id = Auth::id();
        $carts = Cart::getCartProducts($user_id);


        return view('frontend.products.product-grids', compact('products', 'recent_products', 'categories', 'carts'));
    }

    public function productLists()
    {
        $products = Product::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = Categories::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $products->whereIn('cat_id', $cat_ids)->paginate(9);
            // return $products;
        }
        if (!empty($_GET['brand'])) {
            $slugs = explode(',', $_GET['brand']);
            $brand_ids = Brand::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
            return $brand_ids;
            $products->whereIn('brand_id', $brand_ids);
        }
        if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'product_name') {
                $products = $products->where('status', true)->orderBy('product_name', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $products = $products->orderBy('price', 'ASC');
            }
        }

        if (!empty($_GET['price'])) {
            $price = explode('-', $_GET['price']);
            // return $price;
            $products->whereBetween('price', $price);
        }

        $recent_products = Product::getRecentProducts();
        // Sort by number
        if (!empty($_GET['show'])) {
            $products = $products->where('status', true)->paginate($_GET['show']);
        } else {
            $products = $products->where('status', true)->paginate(6);
        }
        // Sort by name , price, category

        $categories = Categories::getCategoryStatusTrue();

        $user_id = Auth::id();
        $carts = Cart::getCartProducts($user_id);


        return view('frontend.products.product-lists', compact('recent_products', 'categories', 'carts'))->with('products', $products);
    }

    public function productDetail($slug)
    {
        $product_detail = Product::getProductBySlug($slug);

        if ($product_detail) {
            $related_products = Product::getRelatedProducts($product_detail->cat_id, $product_detail->id);
        }
        // dd($product_detail);

        return view('frontend.products.product-detail', compact('product_detail', 'related_products'));
    }

    public function productCat(Request $request)
    {
        // $products = Categories::join('products', 'categories.id', '=', 'products.brand_id')
        //     ->select('products.*')
        //     ->where('categories.slug', $request->slug)
        //     ->get();
        $products = Product::getProductByCat($request->slug);
        // dd($products);
        // return $request->slug;
        $recent_products = Product::getRecentProducts();

        if (request()->routeIs('product-grids')) {
            return view('frontend.products.product-grids', compact('products', 'recent_products'));
        } else {
            return view('frontend.products.product-lists', compact('products', 'recent_products'));
        }
    }

    public function productBrand(Request $request)
    {
        // $products = Brand::join('products', 'brands.id', '=', 'products.brand_id')
        //     ->select('products.*')
        //     ->where('brands.slug', $request->slug)
        //     ->paginate(6);
        $products = Product::getProductByBrand($request->slug);
        // dd($products);
        $recent_products = Product::getRecentProducts();

        if (request()->routeIs('product-grids')) {
            return view('frontend.products.product-grids', compact('products', 'recent_products'));
        } else {
            return view('frontend.products.product-lists', compact('products', 'recent_products'));
        }
    }

    public function productFilter(Request $request)
    {
        $data = $request->all();
        // return $data;
        $showURL = "";
        if (!empty($data['show'])) {
            $showURL .= '&show=' . $data['show'];
        }

        $sortByURL = '';
        if (!empty($data['sortBy'])) {
            $sortByURL .= '&sortBy=' . $data['sortBy'];
        }

        $catURL = "";
        if (!empty($data['category'])) {
            foreach ($data['category'] as $category) {
                if (empty($catURL)) {
                    $catURL .= '&category=' . $category;
                } else {
                    $catURL .= ',' . $category;
                }
            }
        }

        $brandURL = "";
        if (!empty($data['brand'])) {
            foreach ($data['brand'] as $brand) {
                if (empty($brandURL)) {
                    $brandURL .= '&brand=' . $brand;
                } else {
                    $brandURL .= ',' . $brand;
                }
            }
        }
        // return $brandURL;

        $priceRangeURL = "";
        if (!empty($data['price_range'])) {
            $priceRangeURL .= '&price=' . $data['price_range'];
        }
        if (request()->is('*/product-grids')) {
            return redirect()->route('product-grids', $catURL . $brandURL . $priceRangeURL . $showURL . $sortByURL);
        } else {
            return redirect()->route('product-lists', $catURL . $brandURL . $priceRangeURL . $showURL . $sortByURL);
        }
    }


    // Auth

    public function login_page()
    {
        $categories = Categories::getCategoryStatusTrue();
        return view('auth.login', compact('categories'));
    }

    public function register_page()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Session::flash('success', 'Successfully Login');
            return redirect()->route('home');
        } else {
            Session::flash('error', 'Invalid username and password pleas try again!');
            return redirect()->back();
        }
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'string|required|min:2',
            'username' => 'string|required|unique:users,username',
            'password' => 'required|min:6|confirmed'
        ]);

        $data = $request->all();
        // dd($data);
        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => Hash::make($data['password'])
        ]);

        Profile::create([
            'name' => $data['name'],
            'user_id' => $user->id,
        ]);

        Session::flash('success', 'Register Berhasil Silahkan Login');
        return back();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect('/');
    }
}
