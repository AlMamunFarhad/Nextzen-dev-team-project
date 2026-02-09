@extends('admin')

@section('content')
<div class="container">
    <h4 class="mb-3 mt-5">Doctor Schedules</h4>

    {{-- Create Schedule --}}
    <div class="card mb-4">
        <div class="card-body">
            <form id="scheduleForm">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <label>Doctor</label>
                        <select name="doctor_id" class="form-control" required>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Day</label>
                        <select name="day" class="form-control" required>
                            @foreach (['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'] as $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Start Time</label>
                        <input type="time" name="start_time" class="form-control" required>
                    </div>

                    <div class="col-md-2">
                        <label>End Time</label>
                        <input type="time" name="end_time" class="form-control" required>
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <button class="btn btn-primary w-100">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Schedule Table --}}
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="scheduleTable">
                <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Slots</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {

    // ==========================
    // Load all schedules
    // ==========================
    function loadSchedules() {
        $.get('/schedules', function(res) {
            const tbody = document.createDocumentFragment();

            res.data.forEach(s => {
                const tr = document.createElement('tr');

                const startTime = new Date('1970-01-01T' + s.start_time)
                    .toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                const endTime = new Date('1970-01-01T' + s.end_time)
                    .toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                tr.innerHTML = `
                    <td>${s.doctor.name}</td>
                    <td>${s.day}</td>
                    <td>${startTime} - ${endTime}</td>
                    <td>${s.slots.map(slot => `<span class="badge bg-info me-1">${slot.slot_time}</span>`).join('')}</td>
                    <td>
                        <button class="btn btn-sm btn-danger deleteBtn" data-id="${s.id}">Delete</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            const tableBody = document.querySelector('#scheduleTable tbody');
            tableBody.innerHTML = '';
            tableBody.appendChild(tbody);
        });
    }

    loadSchedules();

    // ==========================
    // Create Schedule
    // ==========================
    $('#scheduleForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '/schedules',
            method: 'POST',
            data: $(this).serialize(),
            success() {
                $('#scheduleForm')[0].reset();
                loadSchedules();
            },
            error(err) {
                alert(err.responseJSON?.message || 'Error creating schedule');
            }
        });
    });

    // ==========================
    // Delete Schedule
    // ==========================
    $(document).on('click', '.deleteBtn', function() {
        if (!confirm('Delete this schedule?')) return;

        const id = $(this).data('id');

        $.ajax({
            url: `/schedules/${id}`,
            type: 'POST', // POST + method spoofing
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            },
            success() {
                loadSchedules();
            },
            error(err) {
                alert(err.responseJSON?.message || 'Error deleting schedule');
            }
        });
    });

});
</script>
@endpush




{{-- @extends('admin')

@section('content')
    <div class="container">
        <h4 class="mb-3 mt-5">Doctor Schedules</h4>


        <div class="card mb-4">
            <div class="card-body">
                <form id="scheduleForm">
                    @csrf

                    <div class="row">
                        <div class="col-md-3">
                            <label>Doctor</label>
                            <select name="doctor_id" class="form-control" required>
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label>Day</label>
                            <select name="day" class="form-control" required>
                                @foreach (['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                                    <option value="{{ $day }}">{{ $day }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label>Start Time</label>
                            <input type="time" name="start_time" class="form-control" required>
                        </div>

                        <div class="col-md-2">
                            <label>End Time</label>
                            <input type="time" name="end_time" class="form-control" required>
                        </div>

                        <div class="col-md-1 d-flex align-items-end">
                            <button class="btn btn-primary w-100">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="scheduleTable">
                    <thead>
                        <tr>
                            <th>Doctor</th>
                            <th>Day</th>
                            <th>Time</th>
                            <th>Slots</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection --}}
{{-- @push('scripts') --}}
    {{-- <script>
        $(function() {
            loadSchedules();

            function loadSchedules() {
                $.get('/schedules', function(res) {
                    let rows = '';
                    res.data.forEach(s => {
                        rows += `
                <tr>
                    <td>${s.doctor.name}</td>
                    <td>${s.day}</td>
                    <td>
  ${new Date('1970-01-01T' + s.start_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
  -
  ${new Date('1970-01-01T' + s.end_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
</td>

                    <td>
                        ${s.slots.map(slot => `<span class="badge bg-info me-1">${slot.slot_time}</span>`).join('')}
                    </td>
                    <td>
                        <button class="btn btn-sm btn-danger deleteBtn" data-id="${s.id}">Delete</button>
                    </td>
                </tr>`;
                    });
                    $('#scheduleTable tbody').html(rows);
                });
            }

            // Create Schedule
            $('#scheduleForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/schedules',
                    method: 'POST',
                    data: $(this).serialize(),
                    success() {
                        $('#scheduleForm')[0].reset();
                        loadSchedules();
                    },
                    error(err) {
                        alert(err.responseJSON.message || 'Error');
                    }
                });
            });

            // $(document).on('click', '.deleteBtn', function() {
            //     if (!confirm('Delete this schedule?')) return;
            //     let id = $(this).data('id');
            //     $.ajax({
            //         url: `/schedules/${id}`,
            //         type: 'POST', // instead of DELETE
            //         data: {
            //             _token: '{{ csrf_token() }}',
            //             _method: 'DELETE' // Laravel method spoofing
            //         },
            //         success() {
            //             loadSchedules(); // table reload
            //         }
            //     });
            // });

               $(document).on('click', '.deleteBtn', function() {
    if (!confirm('Delete this schedule?')) return;
    let id = $(this).data('id');

    $.ajax({
        url: `/schedules/${id}`,
        type: 'POST', // POST method
        data: {
            _token: '{{ csrf_token() }}',
            _method: 'DELETE' // Laravel recognizes
        },
        success() {
            loadSchedules(); // reload table
        },
        error(err) {
            console.log(err);
        }
    });
});


        });


    </script>
@endpush --}}
