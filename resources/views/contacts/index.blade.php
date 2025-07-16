@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Contacts</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addContactModal">Add Contact</button>
    <a href="{{ route('contacts.merge.form') }}" class="btn btn-warning">Merge Contacts</a>
    <form id="filterForm" class="row g-2 mt-3">
        <input type="hidden" name="filter_trigger" value="1">

        <div class="col"><input type="text" name="name" class="form-control" placeholder="Name"></div>
        <div class="col"><input type="text" name="email" class="form-control" placeholder="Email"></div>
        <div class="col">
            <select name="gender" class="form-control">
                <option value="">Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>
        @foreach($customFields as $field)
            <div class="col">
                <input type="text" name="custom_field[{{ $field->id }}]" class="form-control" placeholder="{{ $field->name }}">
            </div>
        @endforeach
        <div class="col"><button type="submit" class="btn btn-info">Filter</button></div>
    </form>
    <div id="contactsList">
        @include('contacts.partials.list', ['contacts' => $contacts])
    </div>
</div>
@include('contacts.partials.modals')
@endsection
