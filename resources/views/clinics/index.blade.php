@extends('admin')

@section('content')
<div class="container">
    <h4 class="mb-3 mt-5">Clinics</h4>

    <!-- Clinic Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form id="clinicForm">
                @csrf
                <input type="hidden" name="clinic_id" id="clinic_id">

                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Clinic Name</label>
                        <input type="text" name="name" class="form-control">
                        <small class="text-danger name_error field-error"></small>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control">
                        <small class="text-danger phone_error field-error"></small>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control">
                        <small class="text-danger address_error field-error"></small>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Primary Color</label>
                        <input type="color" name="primary_color" class="form-control form-control-color">
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Clinic Table -->
    <div class="card">
        <h5 class="card-header">Clinic List</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Color</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="clinicTableBody"></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
});

let editClinicId = null;

// Render row for table
function renderClinicRow(c){
    return `
    <tr>
        <td><strong>${c.name}</strong></td>
        <td>${c.phone ?? '-'}</td>
        <td>${c.address ?? '-'}</td>
        <td><span style="display:inline-block;width:20px;height:20px;background:${c.primary_color ?? '#000'};border-radius:4px;"></span></td>
        <td>
            <div class="dropdown">
                <button class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item editClinicBtn" data-id="${c.id}"><i class="bx bx-edit-alt me-1"></i>Edit</a>
                    <a class="dropdown-item deleteClinicBtn" data-id="${c.id}"><i class="bx bx-trash me-1"></i>Delete</a>
                </div>
            </div>
        </td>
    </tr>`;
}

// Load clinics table
function loadClinics(){
    $.get("{{ route('clinics.index') }}", res => {
        let html = '';
        (res.data || []).forEach(c => html += renderClinicRow(c));
        $('#clinicTableBody').html(html);
    });
}

// Reset form
function resetForm(){
    $('#clinicForm')[0].reset();
    $('#clinic_id').val('');
    editClinicId = null;
    $('.field-error').text('');
    $('.form-control').removeClass('is-invalid');
}

$(function(){
    loadClinics();

    // Submit form
    $('#clinicForm').submit(function(e){
        e.preventDefault();
        let url = editClinicId ? `/admin/clinics/${editClinicId}` : '/admin/clinics';
        let data = $(this).serialize() + (editClinicId ? '&_method=PUT' : '');

        $.post(url, data)
            .done(() => {
                showToast(editClinicId ? 'Clinic updated successfully!' : 'Clinic created successfully!','success');
                resetForm();
                loadClinics();
            })
            .fail(xhr => {
                if(xhr.status === 422){
                    Object.entries(xhr.responseJSON.errors).forEach(([f,msg])=>{
                        $(`[name="${f}"]`).addClass('is-invalid');
                        $(`.${f}_error`).text(msg[0]);
                    });
                    showToast('Fix errors first','warning');
                } else {
                    showToast('Something went wrong','danger');
                }
            });
    });

    // Edit clinic
    $(document).on('click','.editClinicBtn',function(){
        editClinicId = $(this).data('id');
        $.get(`/admin/clinics/${editClinicId}`, res => {
            let c = res.data ?? res;
            $('[name="name"]').val(c.name);
            $('[name="phone"]').val(c.phone);
            $('[name="address"]').val(c.address);
            $('[name="primary_color"]').val(c.primary_color);
            window.scrollTo({top:0,behavior:'smooth'});
        });
    });

    // Delete clinic
    $(document).on('click','.deleteClinicBtn',function(){
        let id = $(this).data('id');
        $.ajax({
            url:`/admin/clinics/${id}`,
            type:'DELETE'
        }).done(() => {
            showToast('Clinic deleted successfully!','success');
            loadClinics();
        }).fail(() => {
            showToast('Delete failed','danger');
        });
    });
});

// Global toast function
function showToast(msg,type='success'){
    const toastEl = document.getElementById('globalToast');
    if(!toastEl) return;
    const toastMsg = document.getElementById('toastMessage');
    toastEl.className = `toast align-items-center text-bg-${type} border-0`;
    toastMsg.innerText = msg;
    new bootstrap.Toast(toastEl,{delay:3000}).show();
}
</script>
@endpush
