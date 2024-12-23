{{-- Modal Add --}}
<div class="modal fade" id="add-product" tabindex="-1" aria-labelledby="add-product" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-2 text-center" id="add-modal-title">Add New Product</h1>
                </div>
                <div class="modal-body">
                    <form action="{{ route('add-product-admin') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="product_name" class="form-label">Product Name</label>
                            <input type="text" name="product_name" id="product_name" class="form-control" required>
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
                            <textarea name="description" class="form-control" id="editor" cols="30" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="cat_id" class="form-label">Category</label>
                            <select name="cat_id" id="cat_id" class="form-control">
                                @foreach ($categories as $category )
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="brand_id" class="form-label">Brand</label>
                            <select name="brand_id" id="brand_id" class="form-control">
                                @foreach ($brands as $brand )
                                    <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="price" class="form-label">Price</label>
                            <input type="number" name="price" id="price" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" name="stock" id="stock" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <span class="text-danger"></span>
                            <label for="discount" class="form-label">Discount</label>
                            <input type="number" name="discount" id="discount" class="form-control" max="100">
                        </div>
                        <div class="form-group">
                            <span class="text-danger"></span>
                            <label for="size" class="form-label">Size <span class="text-danger">*</span></label>
                            <input type="text" name="size" id="size" class="form-control">
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="condition" class="form-label">Condition</label>
                            <select name="condition" id="condition" class="form-control">
                                @foreach ($conditionOptions as $value => $label )
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="img" class="form-label">Image</label>
                            <input type="file" name="img" id="img" class="form-control-file" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>
{{-- End Modal --}}
