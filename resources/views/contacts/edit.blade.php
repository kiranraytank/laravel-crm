<form id="editContactForm" data-id="{{ $contact->id }}" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Edit Contact</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $contact->name }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $contact->email }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $contact->phone }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-control">
                <option value="">Select</option>
                <option value="male" @if($contact->gender=='male') selected @endif>Male</option>
                <option value="female" @if($contact->gender=='female') selected @endif>Female</option>
                <option value="other" @if($contact->gender=='other') selected @endif>Other</option>
            </select>
        </div>
        @foreach($customFields as $field)
            <div class="mb-3">
                <label class="form-label">{{ $field->name }}</label>
                <input type="text" name="custom_fields[{{ $field->id }}]" class="form-control" value="{{ $customFieldValues[$field->id] ?? '' }}">
            </div>
        @endforeach
        <div class="mb-3">
            <label class="form-label">Profile Image</label>
            <input type="file" name="profile_image" class="form-control">
            @if($contact->profile_image)
                <img src="{{ asset('storage/'.$contact->profile_image) }}" alt="Profile Image" class="img-thumbnail mt-2" width="80">
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Additional File</label>
            <input type="file" name="additional_file" class="form-control">
            @if($contact->additional_file)
                <a href="{{ asset('storage/'.$contact->additional_file) }}" target="_blank" class="d-block mt-2">View File</a>
            @endif
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</form> 