@extends('backend.layouts.master')
@section('title','Faniha | Edit User')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h5 class="m-0 font-weight-bold text-muted">Edit User - {{ $profile->name }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('update-user',['user_id'=>$user->id]) }}" method="POST">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $profile->name }}" required>
            </div>
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ $profile->phone }}">
            </div>
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="cat_id" class="form-label">Address</label>
                <input type="text" name="address" id="address" class="form-control" value="{{ $profile->address }}">
            </div>
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="brand_id" class="form-label">Role</label>
                <select name="role" id="role" class="form-control">
                   @foreach ( $roles as $value => $label)
                        <option value="{{ $value }}" {{ $user->role == $value ? 'selected' : '' }}>{{ $label }}</option>
                   @endforeach
                </select>
            </div>
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="status" class="col-form-label">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="1" {{($user->status) ? 'selected' : ''}}>Active</option>
                    <option value="0" {{(!$user->status) ? 'selected' : ''}}>Inactive</option>
                </select>
            </div>
            <div class="modal-footer">
                <a class="btn btn-danger" href="{{ route('all-users') }}">Cancel</a>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
