<div class="modal fade" id="mergeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="finalMergeForm">
                <div class="modal-header">
                    <h5 class="modal-title">Select Master Contact</h5>
                </div>
                <div class="modal-body">
                    <p>Choose which contact will be the master (primary):</p>
                    <div>
                        <input type="radio" name="master_id" value="{{ $contact1->id }}" checked> {{ $contact1->name }}<br>
                        <input type="radio" name="master_id" value="{{ $contact2->id }}"> {{ $contact2->name }}
                    </div>
                    <input type="hidden" name="secondary_id" value="{{ $contact1->id }}">
                    <input type="hidden" name="secondary_id" value="{{ $contact2->id }}">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Confirm Merge</button>
                </div>
            </form>
        </div>
    </div>
</div>
