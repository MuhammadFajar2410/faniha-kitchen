@extends('backend.layouts.master')
@section('title','Faniha | Edit Brand')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h5 class="m-0 font-weight-bold text-muted">Edit Brand - {{ $brand->brand_name }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ url("brands/edit/$brand->slug") }}" method="POST">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="brand_name" class="col-form-label">Brand Name</label>
                <input type="text" name="brand_name" class="form-control" id="brand_name" value="{{ $brand->brand_name }}" required>
            </div>
            @error('brand_name')
                <span class="text-danger">{{$message}}</span>
            @enderror
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="user_id" class="form-label">User Asign</label>
                <select name="user_id" class="form-control">
                    @foreach ($user_assign as $user_id )
                        <option value="{{ $user_id->id }}">{{ $user_id->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('user_id')
                <span class="text-danger">{{$message}}</span>
            @enderror
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="status" class="col-form-label">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="1" {{($brand->status) ? 'selected' : ''}}>Active</option>
                    <option value="0" {{(!$brand->status) ? 'selected' : ''}}>Inactive</option>
                </select>
            </div>
            @error('status')
                <span class="text-danger">{{$message}}</span>
            @enderror

            <div class="form-group mb-3">
                <a href="{{ route('brands') }}" class="btn btn-danger" >Cancel</a>
                <button class="btn btn-success" type="submit">Update</button>
             </div>
        </form>
    </div>
</div>
@endsection
