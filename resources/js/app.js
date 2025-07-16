import './bootstrap';
import $ from 'jquery';
window.$ = window.jQuery = $;

// Ensure CSRF token is set for all AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('submit', '#filterForm', function(e) {
    e.preventDefault();
    $.ajax({
        // url: '{{ route("contacts.index") }}',
        url: window.laravelRoutes.contactsIndex,
        data: $(this).serialize(),
        success: function(data) {
            console.log('AJAX Reload Success:', data); // 🛠️ Debug here
            $('#contactsList').html(data);
        }
    });
});

$(document).on('submit', '#addContactForm', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        // url: '{{ route("contacts.store") }}',
        url: window.laravelRoutes.contactsStore,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(resp) {
            $('#addContactModal').modal('hide');
            $('#filterForm').submit();
            alert(resp.message);
        }
    });
});

$(document).on('click', '.editContactBtn', function() {
    var id = $(this).data('id');
    $.get('/contacts/' + id + '/edit', function(data) {
        $('#editContactModalContent').html(data);
        $('#editContactModal').modal('show');
    });
});

$(document).on('submit', '#editContactForm', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var formData = new FormData(this);
    $.ajax({
        url: '/contacts/' + id + '/update',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(resp) {
            $('#editContactModal').modal('hide');
            $('#filterForm').submit();
            alert(resp.message);
        }
    });
});

$(document).on('click', '.deleteContactBtn', function() {
    if (!confirm('Delete this contact?')) return;
    var id = $(this).data('id');
    $.ajax({
        url: '/contacts/' + id,
        method: 'DELETE',
        // data: {_token: '{{ csrf_token() }}'},
        data: { _token: window.csrfToken }, // ✅ Fixed here
        success: function(resp) {
            $('#filterForm').submit();
            alert(resp.message);
        }
    });
});

// Merge contacts
$('#openMergeModalBtn').on('click', function() {
    // $.post('{{ route("contacts.merge.modal") }}', $('#mergeForm').serialize(), function(data) {
    $.post(window.laravelRoutes.mergeModal, $('#mergeForm').serialize(), function(data) {
        $('#mergeModalContainer').html(data);
        $('#mergeModal').modal('show');
    });
});

$(document).on('submit', '#finalMergeForm', function(e) {
    e.preventDefault();
    // $.post('{{ route("contacts.merge") }}', $(this).serialize(), function(resp) {
    $.post(window.laravelRoutes.mergeFinal, $(this).serialize(), function(resp) {
        if (resp.success) {
            $('#mergeModal').modal('hide');
            alert(resp.message);
            // window.location.href = '{{ route("contacts.index") }}';
            window.location.href = window.laravelRoutes.contactsIndex;
        }
    });
});

// Add Contact Modal: Load form via AJAX
$(document).on('click', '[data-bs-target="#addContactModal"]', function(e) {
    e.preventDefault();
    $.get('/contacts/create', function(data) {
        $('#addContactModalContent').html(data);
        $('#addContactModal').modal('show');
    });
});
