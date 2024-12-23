@extends('backend.layouts.master')
@section('title','Faniha | User Management')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-muted">User Management</h5>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#add-user">
                    <i class="fas fa-plus mx-1"></i>
                    New User
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="brandsTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($profiles as $profile )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $profile->user->username }}</td>
                                <td>{{ $profile->name}}</td>
                                <td>{{ $profile->phone}}</td>
                                <td>{{ $profile->address}}</td>
                                <td>{{ $profile->user->role }}</td>
                                <td><div class="badge {{ $profile->user->status ? 'bg-primary' : 'bg-danger' }} text-white pill">{{ $profile->user->status ? "Aktif" : "Tidak Aktif" }}</div></td>
                                <td>
                                    <a href="{{ route('edit-user', ['user_id' => $profile->user->id ]) }}" class="btn btn-warning btn-sm" style="height:30px; width:30px;border-radius:50%" ><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <span style="float:right">{{$profiles->links()}}</span>
            </div>
        </div>
    </div>

    @include('backend.users-admin.modals')

@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset('frontend/datatables/dataTables.bootstrap4.min.css') }}">
@endpush
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush

