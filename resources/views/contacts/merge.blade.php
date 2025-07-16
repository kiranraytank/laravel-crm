{{-- REMOVE THIS LINE from views used in modals --}}
{{-- @extends('layouts.app') --}}

{{-- REMOVE @section('content') --}}

<div class="container">
    <h2>Merge Contacts</h2>
    <form id="mergeForm">
        <div class="row">
            <div class="col">
                <label>Select Contact 1</label>
                <select name="contact1" class="form-control">
                    @foreach($contacts as $contact)
                        <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label>Select Contact 2</label>
                <select name="contact2" class="form-control">
                    @foreach($contacts as $contact)
                        <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="button" class="btn btn-primary mt-3" id="openMergeModalBtn">Merge</button>
    </form>
    <div id="mergeModalContainer"></div>
</div>

{{-- REMOVE @endsection --}}
