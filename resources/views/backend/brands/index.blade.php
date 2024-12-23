@extends('backend.layouts.master')
@section('title','Faniha | Brands')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-muted">Brands</h5>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#add-brand">
                    <i class="fas fa-plus mx-1"></i>
                    New Brand
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="brandsTable">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>User Asign</td>
                            <td>Brand Name</td>
                            <td>status</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($brands as $brand )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $brand->user->name }}</td>
                                <td>{{ $brand->brand_name }}</td>
                                <td><div class="badge {{ $brand->status ? 'bg-primary' : 'bg-danger' }} text-white pill">{{ $brand->status ? "Aktif" : "Tidak Aktif" }}</div></td>
                                <td>
                                    <a href="{{ url("brands/edit/$brand->slug") }}" class="btn btn-warning btn-sm modal-edit" style="height:30px; width:30px;border-radius:50%" ><i class="fas fa-edit"></i></a>
                                    <form action="{{ url("brands/$brand->slug") }}" method="POST" id="form-delete" style="display:inline;">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" style="height:30px; width:30px; border-radius:50%">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('backend.brands.modals')
@endsection
@push('script')
<script>
    document.getElementById('form-delete').addEventListener('submit',()=>{
        const confirmed = confirm('Apakah anda yakin ingin melakukan delete');

        if(!confirmed){
            event.preventDefault();
        }
    })
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush
