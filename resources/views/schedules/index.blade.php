@extends('admin')

@section('content')
    <div class="container">
        <h4 class="mb-3 mt-5">Doctor Schedules</h4>

        <div class="card mb-4">
            <div class="card-body">
                <form id="scheduleForm" class="scheduleForm">
                    @csrf
                    <input type="hidden" name="schedule_id" id="schedule_id">

                    <div class="row g-2 align-items-end">
                        <div class="col-md-2 d-flex flex-column">
                            <label class="form-label">Doctor</label>
                            <select name="doctor_id" class="form-control">
                                <option value="">Select Doctor</option>
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger doctor_id_error field-error"></small>
                        </div>

                        <div class="col-md-2 d-flex flex-column">
                            <label class="form-label">Day</label>
                            <select name="day" class="form-control">
                                <option value="">Select Day</option>
                                @foreach (['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                                    <option value="{{ $day }}">{{ $day }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger day_error field-error"></small>
                        </div>

                        <div class="col-md-2 d-flex flex-column">
                            <label class="form-label">Start Time</label>
                            <input type="time" name="start_time" class="form-control schedule-input">
                            <small class="text-danger start_time_error field-error"></small>
                        </div>

                        <div class="col-md-2 d-flex flex-column">
                            <label class="form-label">End Time</label>
                            <input type="time" name="end_time" class="form-control schedule-input">
                            <small class="text-danger end_time_error field-error"></small>
                        </div>

                        <div class="col-md-2 d-flex flex-column">
                            <label class="form-label">Slot Duration (minutes)</label>
                            <input type="number" name="slot_duration" class="form-control schedule-input"
                                placeholder="Duration (minutes)" min="1" value="15">
                            <small class="text-danger slot_duration_error field-error"></small>
                        </div>

                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary w-100" id="submitBtn"
                                class="submitBtn">Save</button>
                            <p style="visibility: hidden; padding: 0; margin: 0;">hello</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <h5 class="card-header">Schedules</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Doctor</th>
                            <th>Day</th>
                            <th>Time (start - end)</th>
                            <th>Slots</th>
                            <th>Info</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="scheduleTableBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .scheduleForm .schedule-input {
            border: 1px solid #d9dee3;
            border-radius: 0.375rem;
            height: 38px;
        }

        .field-error {
            min-height: 18px;
            line-height: 18px;
        }
    </style>
@endpush
@push('scripts')
    <script>
        function confirmDelete(message = 'Are you sure to delete?') {
            return Swal.fire({
                title: 'Confirm Delete',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel'
            });
        }


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // global toast (already exists in main layout)
        function showToast(message, type = 'success') {
            const toastEl = document.getElementById('globalToast');
            const toastMsg = document.getElementById('toastMessage');

            toastEl.classList.remove('text-bg-success', 'text-bg-danger', 'text-bg-warning', 'text-bg-info');
            toastEl.classList.add(`text-bg-${type}`);
            toastMsg.innerText = message;

            new bootstrap.Toast(toastEl, {
                delay: 3000
            }).show();
        }

        let editId = null;

        /* ---------- time helpers ---------- */
        function to24Hour(timeStr) {
            if (!timeStr) return '';
            if (!/AM|PM/i.test(timeStr)) return timeStr.slice(0, 5);

            let [time, modifier] = timeStr.split(' ');
            let [hh, mm] = time.split(':').map(Number);

            if (modifier === 'PM' && hh !== 12) hh += 12;
            if (modifier === 'AM' && hh === 12) hh = 0;

            return `${String(hh).padStart(2,'0')}:${String(mm).padStart(2,'0')}`;
        }

        function formatToAmPm(timeStr) {
            if (!timeStr) return '';
            let [hh, mm] = timeStr.slice(0, 5).split(':').map(Number);
            const ampm = hh >= 12 ? 'PM' : 'AM';
            hh = hh % 12 || 12;
            return `${hh}:${mm.toString().padStart(2,'0')} ${ampm}`;
        }

        function minutesFromMidnight(t) {
            let [h, m] = t.slice(0, 5).split(':').map(Number);
            return h * 60 + m;
        }

        /* ---------- render table ---------- */
        function renderRow(s) {
            const start = formatToAmPm(s.start_time);
            const end = formatToAmPm(s.end_time);

            const total = minutesFromMidnight(s.end_time) - minutesFromMidnight(s.start_time);
            const slots = s.slots || [];
            const each = s.slot_duration || (slots.length ? Math.floor(total / slots.length) : 0);

            return `
      <tr>
        <td><strong>${s.doctor?.name ?? 'N/A'}</strong></td>
        <td>${s.day}</td>
        <td>${start} - ${end}</td>
        <td>${slots.map(sl => `<span class="badge bg-label-info me-1">${formatToAmPm(sl.slot_time)}</span>`).join('')}</td>
        <td>
            <span class="badge bg-label-primary">${total} min</span>
            <span class="badge bg-label-success">${slots.length} slots</span>
            <span class="badge bg-label-secondary">${each} min</span>
        </td>
        <td>
          <div class="dropdown">
            <button class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
              <i class="bx bx-dots-vertical-rounded"></i>
            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item editBtn" data-id="${s.id}"><i class="bx bx-edit-alt me-1"></i>Edit</a>
              <a class="dropdown-item deleteBtn" data-id="${s.id}"><i class="bx bx-trash me-1"></i>Delete</a>
            </div>
          </div>
        </td>
      </tr>`;
        }

        /* ---------- load ---------- */
        function loadSchedules() {
            $.get('/schedules', res => {
                let html = '';
                (res.data || res).forEach(s => html += renderRow(s));
                $('#scheduleTableBody').html(html);
            });
        }

        /* ---------- init ---------- */
        $(function() {

            loadSchedules();

            function clearErrors() {
                $('.field-error').text('');
                $('.form-control').removeClass('is-invalid');
            }

            function resetForm() {
                $('#scheduleForm')[0].reset();
                $('#schedule_id').val('');
                editId = null;
                clearErrors();
            }

            /* ===== submit ===== */
            $('#scheduleForm').submit(function(e) {
                e.preventDefault();
                clearErrors();

                $('input[name="start_time"]').val(to24Hour($('input[name="start_time"]').val()));
                $('input[name="end_time"]').val(to24Hour($('input[name="end_time"]').val()));

                let url = editId ? `/schedules/${editId}` : '/schedules';
                let data = $(this).serialize() + (editId ? '&_method=PUT' : '');

                $.post(url, data)
                    .done(() => {
                        showToast(editId ? 'Schedule updated successfully' :
                            'Schedule created successfully', 'success');
                        resetForm();
                        loadSchedules();
                    })
                    .fail(xhr => {
                        if (xhr.status === 422) {
                            Object.entries(xhr.responseJSON.errors).forEach(([f, msg]) => {
                                $(`[name="${f}"]`).addClass('is-invalid');
                                $(`.${f}_error`).text(msg[0]);
                            });
                            showToast('Please fix the highlighted errors', 'warning');
                        } else {
                            showToast('Something went wrong', 'danger');
                        }
                    });
            });

            /* ===== edit ===== */
            $(document).on('click', '.editBtn', function() {
                editId = $(this).data('id');
                $.get(`/schedules/${editId}`, res => {
                    let d = res.data ?? res;
                    $('[name="doctor_id"]').val(d.doctor_id);
                    $('[name="day"]').val(d.day);
                    $('[name="start_time"]').val(d.start_time.slice(0, 5));
                    $('[name="end_time"]').val(d.end_time.slice(0, 5));
                    $('[name="slot_duration"]').val(d.slot_duration ?? 15);
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            });

            /* ===== delete ===== */
            $(document).on('click', '.deleteBtn', function() {

                let id = $(this).data('id');

                $.ajax({
                    url: `/schedules/${id}`,
                    type: 'DELETE'
                }).done(() => {
                    showToast('Schedule deleted successfully!', 'success');
                    loadSchedules();
                }).fail(() => {
                    showToast('Delete failed', 'danger');
                });
            });

        });
    </script>
@endpush
