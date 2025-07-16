<div class="modal-header">
    <h5 class="modal-title">Merged Contacts</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Name</th><th>Email</th><th>Phone</th><th>Gender</th>
                <th>Merged Into</th><th>Date Merged</th>
                <!-- <th>Action</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->phone }}</td>
                <td>{{ ucfirst($contact->gender) }}</td>
                <td>
                    @if($contact->merged_into_id)
                        {{ optional(optional($contact->mergedFrom->first())->master)->name ?? '-' }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    {{ optional($contact->mergedFrom->first())->created_at?->format('Y-m-d H:i') ?? '-' }}
                </td>
                <!-- <td>
                    <button class="btn btn-sm btn-info viewMergeDetailsBtn" data-id="{{ $contact->id }}">Details</button>
                </td> -->
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
