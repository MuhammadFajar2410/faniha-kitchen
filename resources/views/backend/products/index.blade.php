@extends('backend.layouts.master')
@section('title','Faniha | My Products')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-muted">Products</h5>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#add-product">
                    <i class="fas fa-plus mx-1"></i>
                    New Product
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="brandsTable">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Name</td>
                            <td>Category</td>
                            <td>Brand</td>
                            <td>Price</td>
                            <td>Stok</td>
                            <td>Size</td>
                            <td>Discount</td>
                            <td>Condition</td>
                            <td>Status</td>
                            <td>Image</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->categories->category_name }}</td>
                                <td>{{ $product->brand->brand_name }}</td>
                                <td>{{ 'Rp. ' . number_format($product->price, 0, ',' , '.') }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->size }}</td>
                                <td>{{ $product->discount }}</td>
                                <td>{{ $product->condition }}</td>
                                <td><div class="badge {{ $product->status ? 'bg-primary' : 'bg-danger' }} text-white pill">{{ $product->status ? "Aktif" : "Tidak Aktif" }}</div></td>
                                <td><img src="{{ asset("backend/uploads/image/products/$product->img") }}" alt="{{ $product->category_name }}" width="80"></td>
                                <td>
                                    <a href="{{ route('edit-product', ['slug' => $product->slug]) }}" class="btn btn-warning btn-sm" style="height:30px; width:30px;border-radius:50%" ><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('delete-product', ['slug' => $product->slug]) }}" method="POST" id="form-delete" style="display:inline;">
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
                <span style="float:right">{{$products->links()}}</span>
            </div>
        </div>
    </div>

    @include('backend.products.modals')
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset('frontend/datatables/dataTables.bootstrap4.min.css') }}">
@endpush
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

