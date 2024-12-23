<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Categories;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::getProductBackend(Auth::id());
        // dd($products);
        $categories = Categories::getCategoryStatusTrue();
        $brands = Brand::getBrandStatusTrue();
        $conditionOptions = ['default' => 'Default', 'new' => 'New', 'hot' => 'Hot', 'pre-order' => 'Pre-Order'];

        return view('backend.products.index', compact('products', 'categories', 'brands', 'conditionOptions'));
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
        $validator = Validator::make($request->all(), [
            'cat_id' => 'required',
            'brand_id' => 'required',
            'product_name' => 'required',
            'img' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user_id = Auth::id();

            $input = $request->all();
            $input['user_id'] = $user_id;

            $slug = Str::slug($input['product_name'] . '-' . strtoupper(Str::random(5)));
            $input['slug'] = $slug;

            if ($request->hasFile('img')) {
                $img = $request->file("img");
                $imageName = "IMG" . strtoupper(Str::random(10)) . "." . $img->getClientOriginalExtension();
                $img->move('backend/uploads/image/products', $imageName);
                $input['img'] = $imageName;
            }
            // dd($input);
            Product::create($input);

            Session::flash('Success', 'Product Successfully Added');
            return back();
        } catch (\Exception $e) {
            return back()->withErrors(['Error' => 'An error occurred while saving the data'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $product = Product::getProductBySlug($slug);

        if (!$product) {
            abort(404);
        } else if ($product->user_id != Auth::id()) {
            abort(403);
        }

        $categories = Categories::getCategoryStatusTrue();
        $brands = Brand::getBrandStatusTrue();
        $conditionOptions = ['default' => 'Default', 'new' => 'New', 'hot' => 'Hot', 'pre-order' => 'Pre-Order'];


        return view('backend.products.edit', compact('product', 'categories', 'brands', 'conditionOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $product = Product::getProductBySlug($slug);

        if (!$product) {
            abort(404);
        } else if ($product->user_id != Auth::id()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'cat_id' => 'required',
            'brand_id' => 'required',
            'product_name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'status' => 'required'

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user_id = Auth::id();

            $input = $request->all();
            $input['user_id'] = $user_id;

            $new_slug = Str::slug($input['product_name'] . '-' . strtoupper(Str::random(5)));
            $input['slug'] = $new_slug;

            if ($request->hasFile('img')) {
                File::delete("backend/uploads/image/products/" . $product->img);
                $img = $request->file("img");
                $imageName = "IMG" . strtoupper(Str::random(10)) . "." . $img->getClientOriginalExtension();
                try {
                    $img->move("backend/uploads/image/products/", $imageName);
                } catch (\Exception $e) {
                    return back()
                        ->withErrors(['image' => 'Error moving image: ' . $e->getMessage()])
                        ->withInput();
                }
                $input['img'] = $imageName;
            } else {
                unset($input['img']);
            }
            // dd($input);
            $product->update($input);

            Session::flash('Success', 'Product Successfully Added');
            return redirect()->route('product-backend');
        } catch (\Exception $e) {

            return back()->withErrors(['Error' => 'An error occurred while saving the data'])->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $product = Product::getProductBySlug($slug);

        if (!$product) {
            Session::flash('error', 'Product not found');
        } else if ($product->user_id != Auth::id()) {
            Session::flash('error', 'Unauthorized user access');
            return back();
        }

        $status = $product->delete();

        if ($status) {
            Session::flash('success', 'Product Deleted Successfully');
        } else {
            Session::flash('error', 'An error occurred while deleting');
        }

        return back();
    }

    // admin products
    public function allProduct()
    {
        $products = Product::getAllProductsAdmin();
        $categories = Categories::getCategoryStatusTrue();
        $brands = Brand::getBrandStatusTrue();
        $user_assign = Product::productUserAssign();
        $conditionOptions = ['default' => 'Default', 'new' => 'New', 'hot' => 'Hot', 'pre-order' => 'Pre-Order'];
        return view('backend.products-admin.index', compact('products', 'categories', 'brands', 'conditionOptions', 'user_assign'));
    }

    public function addProductAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cat_id' => 'required',
            'user_id' => 'required',
            'brand_id' => 'required',
            'product_name' => 'required',
            'img' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $input = $request->all();

            $user = Product::productUserAssign();

            if (!$user || !$user->pluck('id')->contains($input['user_id'])) {
                Session::flash('error', 'Unauthorized user access. Only admins and sellers are allowed to perform this action.');
                return back();
            }

            $slug = Str::slug($input['product_name'] . '-' . strtoupper(Str::random(5)));
            $input['slug'] = $slug;

            if ($request->hasFile('img')) {
                $img = $request->file("img");
                $imageName = "IMG" . strtoupper(Str::random(10)) . "." . $img->getClientOriginalExtension();
                $img->move('backend/uploads/image/products', $imageName);
                $input['img'] = $imageName;
            }
            // dd($input);
            Product::create($input);

            Session::flash('Success', 'Product Successfully Added');
            return back();
        } catch (\Exception $e) {
            return back()->withErrors(['Error' => 'An error occurred while saving the data'])->withInput();
        }
    }

    public function deleteProductAdmin($slug)
    {
        $product = Product::getProductBySlug($slug);

        if (!$product) {
            Session::flash('error', 'Product not found');
        }

        $status = $product->delete();

        if ($status) {
            Session::flash('success', 'Product Deleted Successfully');
        } else {
            Session::flash('error', 'An error occurred while deleting');
        }

        return back();
    }

    public function editProductAdmin($slug)
    {
        $product = Product::getProductBySlug($slug);

        if (!$product) {
            Session::flash('error', 'Product Not Found');
        }

        $categories = Categories::getCategoryStatusTrue();
        $brands = Brand::getBrandStatusTrue();
        $conditionOptions = ['default' => 'Default', 'new' => 'New', 'hot' => 'Hot', 'pre-order' => 'Pre-Order'];
        $user_assign = Product::productUserAssign();


        return view('backend.products-admin.edit', compact('product', 'categories', 'brands', 'conditionOptions', 'user_assign'));
    }

    public function updateProductAdmin(Request $request, $slug)
    {
        $product = Product::getProductBySlug($slug);

        if (!$product) {
            abort(404);
        } else if ($product->user_id != Auth::id()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'cat_id' => 'required',
            'brand_id' => 'required',
            'product_name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'status' => 'required'

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {


            $input = $request->all();

            $user = Product::productUserAssign();

            if (!$user || !$user->pluck('id')->contains($input['user_id'])) {
                abort(403);
            }

            $new_slug = Str::slug($input['product_name'] . '-' . strtoupper(Str::random(5)));
            $input['slug'] = $new_slug;

            if ($request->hasFile('img')) {
                File::delete("backend/uploads/image/products/" . $product->img);
                $img = $request->file("img");
                $imageName = "IMG" . strtoupper(Str::random(10)) . "." . $img->getClientOriginalExtension();
                try {
                    $img->move("backend/uploads/image/products/", $imageName);
                } catch (\Exception $e) {
                    return back()
                        ->withErrors(['image' => 'Error moving image: ' . $e->getMessage()])
                        ->withInput();
                }
                $input['img'] = $imageName;
            } else {
                unset($input['img']);
            }
            // dd($input);
            $product->update($input);

            Session::flash('Success', 'Product Successfully Added');
            return redirect()->route('product-backend');
        } catch (\Exception $e) {

            return back()->withErrors(['error' => 'An error occurred while saving the data'])->withInput();
        }
    }
}
