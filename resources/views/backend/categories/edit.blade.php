@extends('backend.layouts.master')
@section('title','Faniha | Edit Category')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h5 class="m-0 font-weight-bold text-muted">Edit Category - {{ $category->category_name }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ url("categories/edit/$category->slug") }}" enctype="multipart/form-data" method="POST">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="category_name" class="col-form-label">Nama Kategori</label>
                <input type="text" name="category_name" class="form-control" id="category_name" value="{{ $category->category_name }}" required>
            </div>
            @error('category_name')
                <span class="text-danger">{{$message}}</span>
            @enderror
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="summary" class="form-label">Ringkasan Kategori</label>
                <textarea type="text" name="summary" id="summary" class="form-control" rows="5" required>{{ $category->summary }}</textarea>
            </div>
            @error('summary')
                <span class="text-danger">{{$message}}</span>
            @enderror
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="status" class="col-form-label">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="1" {{($category->status) ? 'selected' : ''}}>Active</option>
                    <option value="0" {{(!$category->status) ? 'selected' : ''}}>Inactive</option>
                </select>
            </div>
            @error('status')
                <span class="text-danger">{{$message}}</span>
            @enderror
            <div class="form-group">
                <label for="img" class="form-label">Gambar</label>
                <input type="file" name="img" id="img" class="form-control-file" value="{{ $category->img }}">
            </div>
            <div class="form-group mb-3">
                <a href="{{ route('categories') }}" class="btn btn-danger">Cancel</a>
                <button class="btn btn-success" type="submit">Update</button>
             </div>
        </form>
    </div>
</div>
@endsection
