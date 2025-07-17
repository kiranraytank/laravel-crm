@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Manage Custom Fields</h2>
    <form id="addCustomFieldForm" method="POST" action="{{ route('custom_fields.store') }}">
        @csrf
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <input type="text" name="name" placeholder="Field Name" required class="form-control">
            </div>
            <div class="col-auto">
                <select name="type" class="form-control" required>
                    <option value="">Type</option>
                    <option value="text">Text</option>
                    <option value="date">Date</option>
                    <option value="number">Number</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Add Field</button>
            </div>
        </div>
        <div id="addCustomFieldErrors" class="text-danger mt-2"></div>
    </form>
    <table class="table mt-3">
        <thead><tr><th>Name</th><th>Type</th><th>Action</th></tr></thead>
        <tbody>
            @foreach($fields as $field)
            <tr>
                <td>{{ $field->name }}</td>
                <td>{{ $field->type }}</td>
                <td>
                    <button class="btn btn-sm btn-info editCustomFieldBtn" data-id="{{ $field->id }}">Edit</button>
                    <form method="POST" action="{{ route('custom_fields.destroy', $field) }}" class="d-inline deleteCustomFieldForm">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Modal for editing will be loaded here -->
    <div class="modal fade" id="editCustomFieldModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content" id="editCustomFieldModalContent"></div>
      </div>
    </div>
</div>
@endsection