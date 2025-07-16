@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Contacts</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addContactModal">Add Contact</button>
    <button class="btn btn-warning" id="openMergePageBtn">Merge Contacts</button>
    <button class="btn btn-secondary" id="showMergedContactsBtn">Show Merged Contacts</button>
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
        <!-- <div class="col"><button type="submit" class="btn btn-info">Filter</button></div> -->
        <div class="col d-flex gap-2">
            <button type="submit" class="btn btn-info">Filter</button>
            <button type="button" class="btn btn-outline-secondary" id="resetFilterBtn">Reset</button>
        </div>
    </form>
    <div id="contactsList">
        @include('contacts.partials.list', ['contacts' => $contacts])
    </div>
</div>
@include('contacts.partials.modals')
<div class="modal fade" id="mergedContactsModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="mergedContactsModalContent"></div>
  </div>
</div>
@endsection
