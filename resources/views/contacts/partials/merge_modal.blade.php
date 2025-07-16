<div class="modal fade" id="mergeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="finalMergeForm">
                <div class="modal-header">
                    <h5 class="modal-title">Merge Contacts: Choose Values to Keep</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="contact1_id" value="{{ $contact1->id }}">
                    <input type="hidden" name="contact2_id" value="{{ $contact2->id }}">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>{{ $contact1->name }}</th>
                                <th>{{ $contact2->name }}</th>
                                <th>Keep</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td>{{ $contact1->name }}</td>
                                <td>{{ $contact2->name }}</td>
                                <td>
                                    <input type="radio" name="fields[name]" value="{{ $contact1->name }}" checked> 1
                                    <input type="radio" name="fields[name]" value="{{ $contact2->name }}"> 2
                                </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $contact1->email }}</td>
                                <td>{{ $contact2->email }}</td>
                                <td>
                                    <input type="radio" name="fields[email]" value="{{ $contact1->email }}" checked> 1
                                    <input type="radio" name="fields[email]" value="{{ $contact2->email }}"> 2
                                </td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>{{ $contact1->phone }}</td>
                                <td>{{ $contact2->phone }}</td>
                                <td>
                                    <input type="radio" name="fields[phone]" value="{{ $contact1->phone }}" checked> 1
                                    <input type="radio" name="fields[phone]" value="{{ $contact2->phone }}"> 2
                                </td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>{{ ucfirst($contact1->gender) }}</td>
                                <td>{{ ucfirst($contact2->gender) }}</td>
                                <td>
                                    <input type="radio" name="fields[gender]" value="{{ $contact1->gender }}" checked> 1
                                    <input type="radio" name="fields[gender]" value="{{ $contact2->gender }}"> 2
                                </td>
                            </tr>
                            @php
                                $cf1 = $contact1->customFieldValues->pluck('value', 'custom_field_id');
                                $cf2 = $contact2->customFieldValues->pluck('value', 'custom_field_id');
                                $allCustomFieldIds = $cf1->keys()->merge($cf2->keys())->unique();
                            @endphp
                            @foreach($allCustomFieldIds as $cfid)
                                @php
                                    $field = \App\Models\CustomField::find($cfid);
                                @endphp
                                <tr>
                                    <td>{{ $field ? $field->name : 'Custom Field '.$cfid }}</td>
                                    <td>{{ $cf1[$cfid] ?? '' }}</td>
                                    <td>{{ $cf2[$cfid] ?? '' }}</td>
                                    <td>
                                        <input type="radio" name="custom_fields[{{ $cfid }}]" value="{{ $cf1[$cfid] ?? '' }}" @if(($cf1[$cfid] ?? '') !== '') checked @endif> 1
                                        <input type="radio" name="custom_fields[{{ $cfid }}]" value="{{ $cf2[$cfid] ?? '' }}" @if(($cf1[$cfid] ?? '') === '' && ($cf2[$cfid] ?? '') !== '') checked @endif> 2
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="alert alert-info mt-3">
                        <strong>Note:</strong> The secondary contact will be marked as merged. All data will be preserved in the merge history.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Confirm Merge</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
