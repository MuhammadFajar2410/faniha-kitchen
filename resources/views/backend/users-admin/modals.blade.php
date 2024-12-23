{{-- Modal Add --}}
<div class="modal fade" id="add-user" tabindex="-1" aria-labelledby="add-user" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-2 text-center" id="add-modal-title">Add New User</h1>
                </div>
                <div class="modal-body">
                    <form action="{{ route('add-user') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                            @error('name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                            @error('username')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="password" class="form-label">Password</label>
                            <input type="password" autocomplete="" name="password" id="password" class="form-control" required>
                            @error('password')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" autocomplete="" required>
                            @error('password_confirmation')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
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
