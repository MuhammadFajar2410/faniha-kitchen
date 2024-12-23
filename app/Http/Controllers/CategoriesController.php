<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::getAllCategory();
        return view('backend.categories.index', compact('categories'));
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
            'category_name' => 'required|min:3',
            'summary' => 'required:min:3',
            'img' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user_id = Auth::id();
            $input = $request->all();

            $input['user_id'] = $user_id;

            $slug = Str::slug($input['category_name'] . '-' . strtoupper(Str::random(5)));
            $input['slug'] = $slug;

            if ($request->hasFile('img')) {
                $img = $request->file("img");
                $imageName = "IMG" . strtoupper(Str::random(10)) . "." . $img->getClientOriginalExtension();
                $img->move('backend/uploads/image/categories', $imageName);
                $input['img'] = $imageName;
            }

            Categories::create($input);

            Session::flash('Success', 'Category Successfully Added');
            return back();
        } catch (\Exception $e) {
            // Session::flash('error', 'Terjadi kesalahan : ' . $e);
            Session::flash('error', 'An error occurred while saving the data');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $category = Categories::getCategoryBySlug($slug);
        return view('backend.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $category = Categories::getCategoryBySlug($slug);

        $validator = Validator::make($request->all(), [
            'category_name' => 'required|min:3',
            'summary' => 'required|min:3'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user_id = Auth::id();

            $input = $request->all();
            // dd($input);
            $input['user_id'] = $user_id;

            $new_slug = Str::slug($input['category_name'] . '-' . strtoupper(Str::random(5)));
            $input['slug'] = $new_slug;
            // dd($input['img']);
            if ($request->hasFile('img')) {
                File::delete("backend/uploads/image/categories/" . $category->img);
                $img = $request->file('img');
                $imageName = "IMG" . strtoupper(Str::random(10)) . "." . $img->getClientOriginalExtension();
                try {
                    $img->move("backend/uploads/image/categories/", $imageName);
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

            $category->update($input);

            Session::flash('Success', 'Category Updated Successfully');
            return redirect()->route('categories');
        } catch (\Exception $e) {
            Session::flash('error', 'An error occurred while saving the data');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $category = Categories::getCategoryBySlug($slug);
        $status = $category->delete();

        if ($status) {
            Session::flash('success', 'Category Successfully Deleted');
        } else {
            Session::flash('error', 'Error While Deleting');
        }

        return back();
    }
}
