@extends('backend.layouts.master')
@section('title','Faniha | Edit Product')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h5 class="m-0 font-weight-bold text-muted">Edit Product - {{ $product->product_name }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('update-product-admin',['slug'=>$product->slug]) }}" enctype="multipart/form-data" method="POST">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" name="product_name" id="product_name" class="form-control" value="{{ $product->product_name }}" required>
            </div>
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="user_id" class="form-label">User Asign</label>
                <select name="user_id" class="form-control">
                    @foreach ($user_assign as $user_id )
                        <option value="{{ $user_id->id }}">{{ $user_id->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="editor" cols="30" rows="5" required>{{ $product->description }}</textarea>
            </div>
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="cat_id" class="form-label">Category</label>
                <select name="cat_id" id="cat_id" class="form-control">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->cat_id == $category->id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="brand_id" class="form-label">Brand</label>
                <select name="brand_id" id="brand_id" class="form-control">
                    @foreach ($brands as $brand )
                        <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : ''}} >{{ $brand->brand_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="price" class="form-label">Price</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}" required>
            </div>
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="stock" class="form-label">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" value="{{ $product->stock }}" required>
            </div>
            <div class="form-group">
                <span class="text-danger"></span>
                <label for="discount" class="form-label">Discount</label>
                <input type="number" name="discount" id="discount" class="form-control" value="{{ $product->discount }}" max="100">
            </div>
            <div class="form-group">
                <span class="text-danger"></span>
                <label for="size" class="form-label">Size <span class="text-danger">*(Bisa diisi dengan S,M,L,XL atau satuan lainnya)</span></label>
                <input type="text" name="size" id="size" class="form-control" value="{{ $product->size }}">
            </div>
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="condition" class="form-label">Condition</label>
                <select name="condition" id="condition" class="form-control">
                    @foreach ($conditionOptions as $value => $label )
                        <option value="{{ $value }}" {{ $product->condition == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="status" class="col-form-label">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="1" {{($product->status) ? 'selected' : ''}}>Active</option>
                    <option value="0" {{(!$product->status) ? 'selected' : ''}}>Inactive</option>
                </select>
            </div>
            <div class="form-group">
                <span class="text-danger"></span>
                <label for="img" class="form-label">Product Image</label>
                <input type="file" name="img" id="img" class="form-control-file" value="{{ $product->img }}">
            </div>
            <div class="modal-footer">
                <a class="btn btn-danger" href="{{ route('all-products') }}">Cancel</a>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
