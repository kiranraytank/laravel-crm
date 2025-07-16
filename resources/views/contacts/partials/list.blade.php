<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>Name</th><th>Email</th><th>Phone</th><th>Gender</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($contacts as $contact)
        <tr @if($contact->is_merged) class="table-secondary" @endif>
            <td>{{ $contact->name }}</td>
            <td>{{ $contact->email }}</td>
            <td>{{ $contact->phone }}</td>
            <td>{{ ucfirst($contact->gender) }}</td>
            <td>
                <button class="btn btn-sm btn-info editContactBtn" data-id="{{ $contact->id }}">Edit</button>
                <button class="btn btn-sm btn-danger deleteContactBtn" data-id="{{ $contact->id }}">Delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $contacts->links() }}
