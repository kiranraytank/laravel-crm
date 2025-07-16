<form id="addContactForm" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Add Contact</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-control">
                <option value="">Select</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>
        @foreach($customFields as $field)
            <div class="mb-3">
                <label class="form-label">{{ $field->name }}</label>
                <input type="text" name="custom_fields[{{ $field->id }}]" class="form-control">
            </div>
        @endforeach
        <div class="mb-3">
            <label class="form-label">Profile Image</label>
            <input type="file" name="profile_image" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Additional File</label>
            <input type="file" name="additional_file" class="form-control">
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</form> 