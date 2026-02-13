@extends('admin')

@section('content')
<div class="container">
    <h3 class="my-4">Create Appointment</h3>

    <div class="card appointment-card">
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Doctor</label>
                    <select id="doctor_id" class="form-select form-control">
                        <option value="">Select Doctor</option>
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}">
                                {{ $doctor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Patient</label>
                    <select id="patient_id" class="form-select form-control">
                        <option value="">Select Patient</option>
                        @foreach ($patients as $patient)
                            <option value="{{ $patient->id }}">
                                {{ $patient->user->name ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Date</label>
                    <input type="date" id="appointment_date" class="form-control" min="{{ date('Y-m-d') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Available Slots</label>
                <div id="slotContainer" class="d-flex flex-wrap gap-2"></div>
            </div>

            <div class="mb-3">
                <label class="form-label">Notes</label>
                <input type="text" id="notes" class="form-control">
            </div>

            <button id="bookBtn" class="btn btn-primary">
                Book Appointment
            </button>

            <div id="message" class="mt-3"></div>

        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-header">Appointment List</h5>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Doctor</th>
                            <th>Patient</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Notes</th>
                            <th>Status</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="appointmentTable"></tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection


@push('scripts')
<script>
$(document).ready(function () {

    let selectedSlot = null;

    // Time formatter
    function formatTime(time) {
        if (!time) return '';
        let [hour, min] = time.split(':');
        hour = parseInt(hour);
        let ampm = hour >= 12 ? 'PM' : 'AM';
        hour = hour % 12 || 12;
        return `${hour}:${min} ${ampm}`;
    }

    // =========================
    // Load Appointment List
    // =========================
    function loadAppointments() {
        $.get("{{ route('appointments.list') }}", function(response) {
            console.log(response);
            $('#appointmentTable').html('');

            response.forEach(function(a, index) {

                let row = `
                <tr>
                    <td>${index + 1}</td>
                    <td><strong>${a.doctor?.user?.name ?? ''}</strong></td>
                    <td>${a.patient?.user?.name ?? ''}</td>
                    <td>
                        <span class="badge bg-label-primary">
                            ${a.appointment_date}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-label-info">
                            ${formatTime(a.slot?.start_time)} - ${formatTime(a.slot?.end_time)}
                        </span>
                    </td>
                    <td>${a.notes ?? ''}</td>
                    <td>
                        <span class="badge bg-label-success">
                            Booked
                        </span>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item deleteBtn" data-id="${a.id}">
                                    <i class="bx bx-trash me-1"></i>Delete
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                `;

                $('#appointmentTable').append(row);
            });
        });
    }


    // =========================
    // Load Slots
    // =========================
    function loadSlots() {

        let doctor_id = $('#doctor_id').val();
        let date = $('#appointment_date').val();

        if (!doctor_id || !date) return;

        $.get("{{ route('appointments.slots') }}", {
            doctor_id: doctor_id,
            date: date
        }, function(response) {

            $('#slotContainer').html('');
            selectedSlot = null;

            let availableSlots = response.filter(slot => slot.is_booked != 1);

            if (availableSlots.length === 0) {
                $('#slotContainer').html(
                    '<span class="text-danger fw-bold">All slots booked!</span>'
                );
                return;
            }

            availableSlots.forEach(function(slot) {

                let start = formatTime(slot.start_time);
                let end = formatTime(slot.end_time);

                $('#slotContainer').append(`
                    <button type="button"
                        class="btn btn-outline-primary slotBtn"
                        data-id="${slot.id}">
                        ${start} - ${end}
                    </button>
                `);
            });
        });
    }


    // =========================
    // Events
    // =========================

    $(document).on('change', '#doctor_id, #appointment_date', loadSlots);

    $(document).on('click', '.slotBtn', function () {
        $('.slotBtn').removeClass('btn-primary').addClass('btn-outline-primary');
        $(this).removeClass('btn-outline-primary').addClass('btn-primary');
        selectedSlot = $(this).data('id');
    });


    // =========================
    // Book Appointment
    // =========================
    $('#bookBtn').click(function () {

        let doctor_id = $('#doctor_id').val();
        let patient_id = $('#patient_id').val();
        let date = $('#appointment_date').val();
        let notes = $('#notes').val();

        if (!doctor_id || !patient_id || !date || !selectedSlot) {
            $('#message').html('<div class="alert alert-danger">All fields required</div>');
            return;
        }

        $.post("{{ route('appointments.store') }}", {
            _token: "{{ csrf_token() }}",
            doctor_id: doctor_id,
            patient_id: patient_id,
            slot_id: selectedSlot,
            appointment_date: date,
            notes: notes
        }, function(response) {

            $('#message').html(
                '<div class="alert alert-success">Appointment Booked Successfully</div>'
            );

            loadSlots();        // remove booked slot instantly
            loadAppointments(); // refresh list instantly

            $('#notes').val('');
            selectedSlot = null;
        }).fail(function(xhr) {

            let msg = xhr.responseJSON?.message ?? 'Booking failed';
            $('#message').html('<div class="alert alert-danger">'+msg+'</div>');
        });
    });


    // =========================
    // Delete Appointment
    // =========================
    $(document).on('click', '.deleteBtn', function() {

        let id = $(this).data('id');

        if (!confirm('Are you sure?')) return;

        $.ajax({
            url: "/appointments/" + id,
            type: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function() {

                loadAppointments();
                loadSlots();
            }
        });
    });


    // Initial Load
    loadAppointments();

});
</script>
@endpush



{{-- @extends('admin')

@section('content')
    <div class="container">
        <h3 class="my-4">Create Appointment</h3>

        <div class="card appointment-card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Doctor</label>
                        <select id="doctor_id" class="form-select form-control">
                            <option value="">Select Doctor</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}">
                                    {{ $doctor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Patient</label>
                        <select id="patient_id" class="form-select form-control">
                            <option value="">Select Patient</option>
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}">
                                    {{ $patient->user->name ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Date</label>
                        <input type="date" id="appointment_date" class="form-control" min="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Available Slots</label>
                    <div id="slotContainer" class="d-flex flex-wrap gap-2"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notes</label>
                    <input type="text" id="notes" class="form-control">
                </div>

                <button id="bookBtn" class="btn btn-primary">
                    Book Appointment
                </button>

                <div id="message" class="mt-3"></div>

            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-header">Appointment List</h5>

                <div class="table-responsive text-nowrap">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Doctor</th>
                                <th>Patient</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Notes</th>
                                <th>Status</th>
                                <th width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="appointmentTable"></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('styles')
    <style>
        .appointment-card .form-control {
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

            function loadAppointments() {

                $.ajax({
                    url: "{{ route('appointments.index') }}",
                    type: "GET",
                    success: function(response) {

                        $('#appointmentTable').html('');

                        response.data.forEach(function(a, index) {

                            let row = `
                <tr>
                    <td>${index + 1}</td>
                    <td><strong>${a.doctor?.user?.name ?? ''}</strong></td>
                    <td>${a.patient?.user?.name ?? ''}</td>
                    <td>
                        <span class="badge bg-label-primary">
                            ${a.appointment_date}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-label-info">
                            ${formatTime(a.slot?.start_time)} - ${formatTime(a.slot?.end_time)}
                        </span>
                    </td>
                    <td>${a.notes ?? ''}</td>
                    <td>
                        <span class="badge bg-label-success">
                            Booked
                        </span>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item deleteBtn" data-id="${a.id}">
                                    <i class="bx bx-trash me-1"></i>Delete
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                `;

                            $('#appointmentTable').append(row);
                        });
                    }
                });
            }


            let selectedSlot = null;


            function loadSlots() {

                let doctor_id = $('#doctor_id').val();
                let date = $('#appointment_date').val();

                if (!doctor_id || !date) return;

                $.ajax({
                    url: "{{ route('appointments.slots') }}",
                    type: "GET",
                    data: {
                        doctor_id: doctor_id,
                        date: date
                    },
                    success: function(response) {

                        $('#slotContainer').html('');
                        selectedSlot = null;

                        if (response.length === 0) {
                            $('#slotContainer').html('<span class="text-muted">No slots found</span>');
                            return;
                        }

                        // Remove booked slots from list
                        let availableSlots = response.filter(slot => slot.is_booked != 1);

                        if (availableSlots.length === 0) {
                            $('#slotContainer').html(
                                '<span class="text-danger fw-bold">All slots for this date are booked!</span>'
                            );
                            return;
                        }

                        // Helper: 24hr to 12hr AM/PM
                        function formatTime(time) {
                            if (!time) return '';
                            let [hour, min] = time.split(':');
                            hour = parseInt(hour);
                            let ampm = hour >= 12 ? 'PM' : 'AM';
                            hour = hour % 12 || 12;
                            return `${hour}:${min} ${ampm}`;
                        }

                        availableSlots.forEach(function(slot) {

                            let start = formatTime(slot.start_time);
                            let end = formatTime(slot.end_time);

                            $('#slotContainer').append(`
                    <button type="button"
                        class="btn btn-outline-primary slotBtn m-1"
                        data-id="${slot.id}">
                        ${start} - ${end}
                    </button>
                `);
                        });
                    }
                });
            }

            $(document).on('change', '#doctor_id, #appointment_date', function() {
                loadSlots();
            });

            $(document).on('click', '.slotBtn', function() {

                $('.slotBtn').removeClass('btn-primary').addClass('btn-outline-primary');

                $(this).removeClass('btn-outline-primary').addClass('btn-primary');

                selectedSlot = $(this).data('id');
            });

            $('#bookBtn').click(function() {

                let doctor_id = $('#doctor_id').val();
                let patient_id = $('#patient_id').val();
                let date = $('#appointment_date').val();
                let notes = $('#notes').val();


                console.log({
                    doctor_id,
                    patient_id,
                    date,
                    selectedSlot
                });
                if (!doctor_id || !patient_id || !date || !selectedSlot) {
                    $('#message').html('<div class="alert alert-danger">All fields required</div>');
                    return;
                }

                $.ajax({
                    url: "{{ route('appointments.store') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        doctor_id: doctor_id,
                        patient_id: patient_id,
                        slot_id: selectedSlot,
                        appointment_date: date,
                        notes: notes
                    },
                    success: function(response) {

                        $('#message').html(
                            '<div class="alert alert-success">Appointment Booked Successfully</div>'
                        );

                        loadSlots();

                        $('#notes').val('');
                    },
                    error: function(xhr) {

                        let msg = xhr.responseJSON?.message ?? 'Booking failed';
                        $('#message').html('<div class="alert alert-danger">' + msg + '</div>');
                    }
                });

            });

        });
    </script>
@endpush --}}
