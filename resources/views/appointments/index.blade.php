@extends('admin')

@section('content')
<div class="container">
    <h3 class="my-4">Appointment Management</h3>

    <div class="card appointment-card">
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Doctor</label>
                    <select id="doctor_id" class="form-select form-control">
                        <option value="">Select Doctor</option>
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Patient</label>
                    <select id="patient_id" class="form-select form-control">
                        <option value="">Select Patient</option>
                        @foreach ($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->user->name ?? 'N/A' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Date</label>
                    <input type="date" id="appointment_date" class="form-control" min="{{ date('Y-m-d') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select id="status" class="form-select form-control">
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
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

            <button id="bookBtn" class="btn btn-primary">Book Appointment</button>
            <div id="createMessage" class="mt-3"></div>

        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-header">Appointments</h5>
            <div id="deleteMessage" class="mb-3"></div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Doctor</th>
                            <th>Patient</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Notes</th>
                            <th>Status</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $a)
                        <tr>
                            <td><strong>{{ $a->doctor->user->name ?? '' }}</strong></td>
                            <td>{{ $a->patient->user->name ?? '' }}</td>
                            <td><span class="badge bg-label-primary">{{ $a->appointment_date }}</span></td>
                            <td><span class="badge bg-label-info">{{ \Carbon\Carbon::parse($a->slot->slot_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($a->slot->end_time)->format('h:i A') }}</span></td>
                            <td>{{ $a->notes ?? '' }}</td>
                            <td>
                                @switch($a->status)
                                    @case('pending')
                                        <span class="badge bg-label-warning">Pending</span>
                                        @break
                                    @case('approved')
                                        <span class="badge bg-label-primary">Approved</span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-label-success">Completed</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-label-danger">Cancelled</span>
                                        @break
                                    @default
                                        <span class="badge bg-label-secondary">Unknown</span>
                                @endswitch
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item editBtn" data-id="{{ $a->id }}"><i class="bx bx-edit-alt me-1"></i>Edit</a>
                                        <a class="dropdown-item deleteBtn" data-id="{{ $a->id }}"><i class="bx bx-trash me-1"></i>Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Laravel pagination links -->
                <div class="d-flex justify-content-center mt-2">
                    {{ $appointments->links() }}
                </div>
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
    border: 1px solid #d9dee3;
    border-radius: 0.375rem;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.slotBtn { min-width: 110px; }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function(){

    let selectedSlot=null, editId=null, originalData={};

    function showMessage(type,msg,target){
        let alertClass = type==='success'?'alert alert-success':'alert alert-danger';
        let divId = target==='delete'?'#deleteMessage':'#createMessage';
        $(divId).html(`<div class="${alertClass} shadow-sm py-2 px-3 rounded">${msg}</div>`);
        setTimeout(()=>$(divId).fadeOut(300,function(){$(this).html('').show();}),3000);
    }

    function resetForm(){
        editId=null; selectedSlot=null; originalData={};
        $('#doctor_id').val(''); $('#patient_id').val(''); $('#appointment_date').val(''); $('#notes').val('');
        $('#slotContainer').html(''); $('#status').val('pending');
    }

    function formatTime(time){
        if(!time) return '';
        let [h,m]=time.split(':'); h=parseInt(h);
        let ampm=h>=12?'PM':'AM'; h=h%12||12;
        return `${h}:${m} ${ampm}`;
    }

    function loadSlots(){
        let doctor_id=$('#doctor_id').val(), date=$('#appointment_date').val();
        if(!doctor_id||!date) return;
        $('#slotContainer').html(''); selectedSlot=null;
        $.get("{{ route('appointments.slots') }}",{doctor_id,date},function(slots){
            if(!slots.length){ $('#slotContainer').html('<span class="text-warning fw-bold">No slots available!</span>'); return; }
            slots.forEach(s=>{
                let btn=$(`<button type="button" class="btn slotBtn m-1" data-id="${s.id}">${formatTime(s.start_time)} - ${formatTime(s.end_time)}</button>`);
                if(s.is_booked){ btn.addClass('btn-secondary').prop('disabled',true).css('opacity',0.6); }
                else btn.addClass('btn-outline-primary');
                $('#slotContainer').append(btn);
            });
            if(editId && originalData.slot_id){
                $('.slotBtn').each(function(){ if($(this).data('id')==originalData.slot_id){ $(this).removeClass('btn-outline-primary').addClass('btn-primary'); selectedSlot=originalData.slot_id; } });
            }
        });
    }

    $(document).on('change','#doctor_id,#appointment_date',loadSlots);

    $(document).on('click','.slotBtn:not(:disabled)',function(){
        $('.slotBtn').removeClass('btn-primary').addClass('btn-outline-primary');
        $(this).removeClass('btn-outline-primary').addClass('btn-primary');
        selectedSlot=$(this).data('id');
    });

    // Edit
    $(document).on('click','.editBtn',function(){
        let id=$(this).data('id');
        $.get("/appointments/"+id,function(a){
            editId=a.id;
            originalData={doctor_id:a.doctor_id,patient_id:a.patient_id,appointment_date:a.appointment_date,slot_id:a.slot_id,notes:a.notes??'',status:a.status??'pending'};
            $('#doctor_id').val(a.doctor_id); $('#patient_id').val(a.patient_id); $('#appointment_date').val(a.appointment_date);
            $('#notes').val(a.notes); $('#status').val(a.status??'pending');
            loadSlots();
        });
    });

    // Book / Update
    $('#bookBtn').click(function(){
        let doctor_id=$('#doctor_id').val(), patient_id=$('#patient_id').val(), date=$('#appointment_date').val(), notes=$('#notes').val()??'', status=$('#status').val();
        if(!doctor_id||!patient_id||!date){ showMessage('error','Please complete all required fields.','create'); return; }
        if(editId && !selectedSlot) selectedSlot=originalData.slot_id;

        let url=editId?"/appointments/"+editId:"{{ route('appointments.store') }}";
        let type=editId?"PUT":"POST";

        $.ajax({
            url:url,type:type,
            data:{_token:"{{ csrf_token() }}",doctor_id,patient_id,slot_id:selectedSlot,appointment_date:date,notes,status},
            success:function(){
                showMessage('success',editId?'Appointment updated successfully.':'Appointment booked successfully.','create');
                window.location.reload(); // simple reload to refresh table + pagination
            },
            error:function(xhr){ let msg=xhr.responseJSON?.message??'Something went wrong.'; showMessage('error',msg,'create'); }
        });
    });

    // Delete
    $(document).on('click','.deleteBtn',function(){
        let id=$(this).data('id'); if(!confirm('Are you sure?')) return;
        $.ajax({
            url:"/appointments/"+id,type:"DELETE",data:{_token:"{{ csrf_token() }}"},
            success:function(){ showMessage('danger','Appointment deleted successfully.','delete'); window.location.reload(); }
        });
    });

});
</script>
@endpush
