@extends('admin')

@section('content')
    <div class="container">
        <h3 class="mb-y">Patient Management</h3>

        <div class="card mb-4 patient-card">
            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">User</label>
                        <select id="user_id" class="form-select form-control">
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Age</label>
                        <input type="number" id="age" class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Gender</label>
                        <select id="gender" class="form-select form-control">
                            <option value="">Select</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Address</label>
                        <input type="text" id="address" class="form-control">
                    </div>

                </div>

                <button id="savePatient" class="btn btn-primary mt-3">
                    Save Patient
                </button>

                <div id="message" class="mt-3"></div>

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-header">Patients</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Address</th>
                                <th width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="patientTable"></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('styles')
    <style>
        .patient-card .form-control {
            display: block;
            width: 100%;
            padding: 0.4375rem 0.875rem;
            font-size: 0.9375rem;
            font-weight: 400;
            line-height: 1.53;
            color: #697a8d;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #d9dee3;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0.375rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {

            let editId = null;

            function loadPatients() {
                $.get("{{ route('patients.data') }}", function(res) {

                    $('#patientTable').html('');

                    res.data.forEach(function(p, index) {

                        $('#patientTable').append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td><strong>${p.user?.name ?? ''}</strong></td>
                        <td>${p.user?.email ?? ''}</td>
                        <td>${p.age ?? ''}</td>
                        <td>
                            <span class="badge bg-label-info">${p.gender ?? ''}</span>
                        </td>
                        <td>${p.address ?? ''}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item editBtn" style="cursor: pointer;"
                                        data-id="${p.id}"
                                        data-user_id="${p.user_id}"
                                        data-age="${p.age ?? ''}"
                                        data-gender="${p.gender ?? ''}"
                                        data-address="${p.address ?? ''}">
                                        <i class="bx bx-edit-alt me-1"></i>Edit
                                    </a>
                                    <a class="dropdown-item deleteBtn" style="cursor: pointer;" data-id="${p.id}">
                                        <i class="bx bx-trash me-1"></i>Delete
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                `);
                    });

                });
            }

            loadPatients();

            $('#savePatient').click(function() {

                let user_id = $('#user_id').val();
                let age = $('#age').val();
                let gender = $('#gender').val();
                let address = $('#address').val();

                let url = editId ? `/patients/${editId}` : "/patients";
                let type = editId ? "PUT" : "POST";

                $.ajax({
                    url: url,
                    type: type,
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_id: user_id,
                        age: age,
                        gender: gender,
                        address: address
                    },
                    success: function(res) {

                        $('#message').html(
                            '<div class="alert alert-success">Saved Successfully</div>');

                        $('#age').val('');
                        $('#gender').val('');
                        $('#address').val('');
                        $('#user_id').val('');

                        editId = null;

                        loadPatients();
                    },
                    error: function(xhr) {

                        let msg = xhr.responseJSON?.message ?? 'Something went wrong';
                        $('#message').html('<div class="alert alert-danger">' + msg + '</div>');
                    }
                });
            });

            $(document).on('click', '.editBtn', function() {

                editId = $(this).data('id');

                $('#age').val($(this).data('age'));
                $('#user_id').val($(this).data('user_id'));
                $('#gender').val($(this).data('gender'));
                $('#address').val($(this).data('address'));

                $('html, body').animate({
                    scrollTop: 0
                }, 'slow');
            });

            $(document).on('click', '.deleteBtn', function() {

                if (!confirm("Are you sure?")) return;

                let id = $(this).data('id');

                $.ajax({
                    url: `/patients/${id}`,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function() {
                        loadPatients();
                    }
                });
            });

        });
    </script>
@endpush
