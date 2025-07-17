<div class="modal-header">
    <h5 class="modal-title">Merge Details</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
    <h6>Master Contact (Before Merge)</h6>
    <pre>{{ json_encode($merge->merged_data['old_master'], JSON_PRETTY_PRINT) }}</pre>
    <h6>Secondary Contact (Before Merge)</h6>
    <pre>{{ json_encode($merge->merged_data['old_secondary'], JSON_PRETTY_PRINT) }}</pre>
    <h6>Selected Fields</h6>
    <pre>{{ json_encode($merge->merged_data['selected_fields'], JSON_PRETTY_PRINT) }}</pre>
    <h6>Selected Custom Fields</h6>
    <pre>{{ json_encode($merge->merged_data['selected_custom_fields'], JSON_PRETTY_PRINT) }}</pre>
</div> 