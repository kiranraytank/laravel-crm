@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Custom Fields</h2>
    <form method="POST" action="{{ route('custom_fields.store') }}">
        @csrf
        <input type="text" name="name" placeholder="Field Name" required>
        <select name="type">
            <option value="text">Text</option>
            <option value="date">Date</option>
            <option value="number">Number</option>
        </select>
        <button type="submit" class="btn btn-primary">Add Field</button>
    </form>
    <table class="table mt-3">
        <thead><tr><th>Name</th><th>Type</th><th>Action</th></tr></thead>
        <tbody>
            @foreach($fields as $field)
            <tr>
                <td>{{ $field->name }}</td>
                <td>{{ $field->type }}</td>
                <td>
                    <form method="POST" action="{{ route('custom_fields.destroy', $field) }}">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection