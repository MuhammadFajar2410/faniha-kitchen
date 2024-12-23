{{-- Modal Add --}}
<div class="modal fade" id="add-category" tabindex="-1" aria-labelledby="add-category" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-2 text-center" id="add-modal-title">Tambah Category</h1>
                </div>
                <div class="modal-body">
                    <form action="{{ url('categories') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="category_name" class="form-label">Nama Kategori</label>
                            <input type="text" name="category_name" id="category_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="summary" class="form-label">Ringkasan Kategori</label>
                            <textarea type="text" name="summary" id="summary" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="img" class="form-label">Gambar</label>
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
