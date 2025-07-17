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
    $('#addContactForm .alert').remove(); 
    $('#addContactForm input, #addContactForm select').removeClass('is-invalid');


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

            $('body').removeClass('modal-open'); // remove modal-open class from body
            $('.modal-backdrop').remove();       // remove the dark background overlay

            $('#filterForm').submit();
            // alert(resp.message);
            showAlert('success', resp.message); // ✅ Success alert
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                let errorHtml = '<ul class="mb-0">';
                let firstErrorField = null;

                // Remove previous error highlights
                $('#addContactForm input, #addContactForm select').removeClass('is-invalid');

                $.each(errors, function(key, messages) {
                    const fieldName = key.replace(/\./g, '\\.'); // dot-notation fix
                    const field = $(`[name="${fieldName}"]`);

                    if (!firstErrorField) firstErrorField = field;

                    field.addClass('is-invalid'); // Bootstrap red border
                    errorHtml += `<li>${messages[0]}</li>`;
                });

                errorHtml += '</ul>';

                const alertHtml = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ${errorHtml}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                
                $('#addContactForm .modal-body').prepend(alertHtml);

                // Scroll to first error field
                if (firstErrorField && firstErrorField.length) {
                    firstErrorField[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstErrorField.focus();
                }
            } else {
                console.error("Unexpected error:", xhr);
                showAlert('danger', 'An unexpected error occurred.');
            }
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

// $(document).on('submit', '#finalMergeForm', function(e) {
//     e.preventDefault();
//     // $.post('{{ route("contacts.merge") }}', $(this).serialize(), function(resp) {
//     $.post(window.laravelRoutes.mergeFinal, $(this).serialize(), function(resp) {
//         if (resp.success) {
//             // $('#mergeModal').modal('hide');
//              let modalElement = document.getElementById('mergeModal');
//             let modalInstance = bootstrap.Modal.getInstance(modalElement);
//             modalInstance.hide();
//             // alert(resp.message);
//             showAlert('success', resp.message); // ✅ Success alert
//             // window.location.href = '{{ route("contacts.index") }}';
//             window.location.href = window.laravelRoutes.contactsIndex;
//         }
//     });
// });

$(document).on('submit', '#finalMergeForm', function(e) {
    e.preventDefault();
    const form = $(this);
    $.ajax({
        url: window.laravelRoutes.mergeFinal,
        method: 'POST',
        data: form.serialize(),
        success: function(resp) {
            if (resp.success) {
                let modalElement = document.getElementById('mergeModal');
                let modalInstance = bootstrap.Modal.getInstance(modalElement);
                modalInstance.hide();
                showAlert('success', resp.message);
                window.location.href = window.laravelRoutes.contactsIndex;
            }
        },
        error: function(xhr) {
            // Laravel sends validation errors with status 422
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                let errorHtml = '<ul class="mb-0">';
                $.each(errors, function(key, messages) {
                    $.each(messages, function(_, msg) {
                        errorHtml += `<li>${msg}</li>`;
                    });
                });
                errorHtml += '</ul>';

                // Append errors inside the modal alert container
                const alertHtml = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ${errorHtml}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                
                $('#mergeModal .modal-body').prepend(alertHtml);
            } else {
                console.error("Unexpected error:", xhr);
                showAlert('danger', 'An unexpected error occurred.');
            }
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

$(document).on('click', '#showMergedContactsBtn', function(e) {
    e.preventDefault();
    $.get('/contacts/merged-list', function(data) {
        $('#mergedContactsModalContent').html(data);
        const modal = new bootstrap.Modal(document.getElementById('mergedContactsModal'));
        modal.show();
    });
});

$(document).on('click', '.viewMergeDetailsBtn', function(e) {
    e.preventDefault();
    var contactId = $(this).data('id');
    $.get('/contacts/merge-details/' + contactId, function(data) {
        $('#mergeDetailsModalContent').html(data);
        const modal = new bootstrap.Modal(document.getElementById('mergeDetailsModal'));
        modal.show();
    });
});


//  Reset the Filter and Reload Data
$(document).on('click', '#resetFilterBtn', function () {
    $('#filterForm')[0].reset(); // ✅ Actually clears all inputs
    $('#filterForm input[name^="custom_field"]').val(''); // ✅ Clear custom field values
    $('input[name="filter_trigger"]').val(''); // Optional: clear hidden flag
    $('#filterForm').submit(); // ✅ Trigger AJAX reload with empty filters
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

// AJAX: Add Custom Field
$(document).on('submit', '#addCustomFieldForm', function(e) {
    e.preventDefault();
    var form = $(this);
    var formData = form.serialize();
    form.find('input, select').removeClass('is-invalid');
    $('#addCustomFieldErrors').empty();
    $.post(form.attr('action'), formData)
        .done(function() { location.reload(); })
        .fail(function(xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                let errorHtml = '<ul class="mb-0">';
                $.each(errors, function(key, messages) {
                    form.find(`[name="${key}"]`).addClass('is-invalid');
                    errorHtml += `<li>${messages[0]}</li>`;
                });
                errorHtml += '</ul>';
                $('#addCustomFieldErrors').html(errorHtml);
            }
        });
});
// AJAX: Edit Custom Field (open modal)
$(document).on('click', '.editCustomFieldBtn', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    $.get('/custom-fields/' + id + '/edit', function(field) {
        let modalHtml = `
            <form id="editCustomFieldForm" data-id="${field.id}">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Custom Field</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="name" value="${field.name}" required class="form-control mb-2">
                    <select name="type" class="form-control" required>
                        <option value="text" ${field.type === 'text' ? 'selected' : ''}>Text</option>
                        <option value="date" ${field.type === 'date' ? 'selected' : ''}>Date</option>
                        <option value="number" ${field.type === 'number' ? 'selected' : ''}>Number</option>
                    </select>
                    <div id="editCustomFieldErrors" class="text-danger mt-2"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        `;
        $('#editCustomFieldModalContent').html(modalHtml);
        const modal = new bootstrap.Modal(document.getElementById('editCustomFieldModal'));
        modal.show();
    });
});
// AJAX: Edit Custom Field (submit)
$(document).on('submit', '#editCustomFieldForm', function(e) {
    e.preventDefault();
    var form = $(this);
    var id = form.data('id');
    var formData = form.serialize();
    form.find('input, select').removeClass('is-invalid');
    $('#editCustomFieldErrors').empty();
    $.post('/custom-fields/' + id + '/update', formData)
        .done(function() { location.reload(); })
        .fail(function(xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                let errorHtml = '<ul class="mb-0">';
                $.each(errors, function(key, messages) {
                    form.find(`[name="${key}"]`).addClass('is-invalid');
                    errorHtml += `<li>${messages[0]}</li>`;
                });
                errorHtml += '</ul>';
                $('#editCustomFieldErrors').html(errorHtml);
            }
        });
});
// AJAX: Delete Custom Field
$(document).on('submit', '.deleteCustomFieldForm', function(e) {
    e.preventDefault();
    if (!confirm('Delete this custom field?')) return;
    var form = $(this);
    $.ajax({
        url: form.attr('action'),
        method: 'POST',
        data: form.serialize(),
        success: function() { location.reload(); }
    });
});
