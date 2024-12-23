{{-- Modal Add --}}
<div class="modal fade" id="add-brand" tabindex="-1" aria-labelledby="add-brand" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-2 text-center" id="add-brand-title">Add New Brand</h1>
                </div>
                <div class="modal-body">
                    <form action="{{ url('brands') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="brand_name" class="form-label">Brand Name</label>
                            <input type="text" name="brand_name" id="brand_name" class="form-control" required>
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
