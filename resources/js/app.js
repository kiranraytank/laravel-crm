import './bootstrap';
import $ from 'jquery';
window.$ = window.jQuery = $;

import * as bootstrap from 'bootstrap'; // ✅ correctly imports Bootstrap's JS
window.bootstrap = bootstrap;

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
            // console.log('AJAX Reload Success:', data); // 🛠️ Debug here
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
            // $('#addContactModal').modal('hide');
             let modalElement = document.getElementById('addContactModal');
            let modalInstance = bootstrap.Modal.getInstance(modalElement);
            modalInstance.hide();
            $('#filterForm').submit();
            // alert(resp.message);
            showAlert('success', resp.message); // ✅ Success alert
        }
    });
});

$(document).on('click', '.editContactBtn', function() {
    var id = $(this).data('id');
    $.get('/contacts/' + id + '/edit', function(data) {
        $('#editContactModalContent').html(data);
        // $('#editContactModal').modal('show');
        const modal = new bootstrap.Modal(document.getElementById('editContactModal'));
        modal.show();
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
            let modalElement = document.getElementById('editContactModal');
            let modalInstance = bootstrap.Modal.getInstance(modalElement);
            modalInstance.hide();

            $('#filterForm').submit();
            // alert(resp.message);
            showAlert('success', resp.message); // ✅ Success alert
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
            // alert(resp.message);
            showAlert('success', resp.message); // ✅ Success alert
        }
    });
});

// Merge contacts
$('#openMergeModalBtn').on('click', function() {
    // $.post('{{ route("contacts.merge.modal") }}', $('#mergeForm').serialize(), function(data) {
    $.post(window.laravelRoutes.mergeModal, $('#mergeForm').serialize(), function(data) {
        $('#mergeModalContainer').html(data);
        // $('#mergeModal').modal('show');
        const modal = new bootstrap.Modal(document.getElementById('mergeModal'));
        modal.show();
    });
});

$(document).on('submit', '#finalMergeForm', function(e) {
    e.preventDefault();
    // $.post('{{ route("contacts.merge") }}', $(this).serialize(), function(resp) {
    $.post(window.laravelRoutes.mergeFinal, $(this).serialize(), function(resp) {
        if (resp.success) {
            // $('#mergeModal').modal('hide');
             let modalElement = document.getElementById('mergeModal');
            let modalInstance = bootstrap.Modal.getInstance(modalElement);
            modalInstance.hide();
            // alert(resp.message);
            showAlert('success', resp.message); // ✅ Success alert
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
        // $('#addContactModal').modal('show');
        const modal = new bootstrap.Modal(document.getElementById('addContactModal'));
        modal.show();
    });
});

// Open Merge Contacts modal from main page
// Open Merge Contacts modal from main page
// $(document).on('click', '#openMergePageBtn', function(e) {
//     e.preventDefault();
//     $.get('/contacts/merge', function(data) {
//         // Create a modal container if not exists
//         if ($('#mergePageModal').length === 0) {
//             $('body').append('<div class="modal fade" id="mergePageModal" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content" id="mergePageModalContent"></div></div></div>');
//         }
        
//         $('#mergePageModalContent').html(data); // Load entire Blade view (not just .container)
//         const modal = new bootstrap.Modal(document.getElementById('mergePageModal'));
//         modal.show();
//     });
// });

// This is good and should stay:
$(document).on('click', '#openMergePageBtn', function(e) {
    e.preventDefault();
    $.get('/contacts/merge', function(data) {
        if ($('#mergePageModal').length === 0) {
            $('body').append(`
                <div class="modal fade" id="mergePageModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" id="mergePageModalContent"></div>
                    </div>
                </div>
            `);
        }

        // ✅ Inject entire form directly since layout was removed
        $('#mergePageModalContent').html(data);

        const modal = new bootstrap.Modal(document.getElementById('mergePageModal'));
        modal.show();
    });
});



$(document).on('click', '#openMergeModalBtn', function () {
    $.post(window.laravelRoutes.mergeModal, $('#mergeForm').serialize(), function (data) {
        $('#mergeModalContainer').html(data); // ✅ modal HTML injected

        const modalElement = document.getElementById('mergeModal');
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
    });
});




function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
    $('#alertMessage').html(alertHtml);
}

setTimeout(() => {
    $('.alert').alert('close');
}, 10000);
