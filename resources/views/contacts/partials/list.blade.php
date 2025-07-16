<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>Name</th><th>Email</th><th>Phone</th><th>Gender</th>
                

            @if($contacts->first() && $contacts->first()->customFieldValues)
                @foreach($contacts->first()->customFieldValues as $cfv)
                    <th>{{ $cfv->customField->name }}</th>
                @endforeach
            @endif
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
            @foreach($contact->customFieldValues as $cfv)
                <td>{{ $cfv->value }}</td>
            @endforeach
            <td>
                <button class="btn btn-sm btn-info editContactBtn" data-id="{{ $contact->id }}">Edit</button>
                <button class="btn btn-sm btn-danger deleteContactBtn" data-id="{{ $contact->id }}">Delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $contacts->links() }}
