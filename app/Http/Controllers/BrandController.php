<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::getAllBrand();
        $user_assign = Brand::getUserAssign();
        return view('backend.brands.index', compact('brands', 'user_assign'));
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
            'brand_name' => 'required|min:3',
            'user_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $input = $request->all();
        // dd($input);
        $user = Brand::getUserAssign();
        if (!$user || !$user->pluck('id')->contains($input['user_id'])) {
            Session::flash('error', 'Unauthorized user access. Only admins and sellers are allowed to perform this action.');
            return back();
        }

        $slug = Str::slug($input['brand_name']  . '-' . strtoupper(Str::random(5)));
        $input['slug'] = $slug;

        Brand::create($input);
        Session::flash('success', 'Brand Successfully Added');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $brand = Brand::getBrandBySlug($slug);
        $user_assign = Brand::getUserAssign();

        return view('backend.brands.edit', compact('brand', 'user_assign'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'brand_name' => 'required|min:3'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $input = $request->all();

        $user = Brand::getUserAssign();
        if (!$user || !$user->pluck('id')->contains($input['user_id'])) {
            Session::flash('error', 'Unauthorized user access. Only admins and sellers are allowed to perform this action.');
            return back();
        }

        $new_slug = Str::slug($input['brand_name']  . '-' . strtoupper(Str::random(5)));
        $input['slug'] = $new_slug;

        Brand::getBrandBySlug($slug)->update($input);
        Session::flash('success', "Brand Berhasil diupdate");

        return redirect()->route('brands');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $brand = Brand::where('slug', $slug)->first();
        $status = $brand->delete();

        if ($status) {
            Session::flash('success', 'Brand Deleted Successfully');
        } else {
            Session::flash('error', 'An error occurred while deleting');
        }

        return back();
    }
}
