@extends('admin')
@section('content')
<h3>Manual Booking</h3>
<form method="POST" action="{{ route('admin.manual.book') }}">
  @csrf
  <div class="mb-2">
    <label>Clinic</label>
    <select id="clinic" name="clinic_id" class="form-control">
      <option value="">Select</option>
      @foreach($clinics as $c)
        <option value="{{ $c->id }}">{{ $c->name }}</option>
      @endforeach
    </select>
  </div>

  <div class="mb-2">
    <label>Doctor</label>
    <select id="doctor" name="doctor_id" class="form-control">
      <option value="">Select clinic first</option>
    </select>
  </div>

  <div class="mb-2">
    <label>Patient (ID)</label>
    <input type="text" name="patient_id" class="form-control" placeholder="enter patient id or search via autocomplete">
  </div>

  <div class="mb-2">
    <label>Scheduled At</label>
    <input type="datetime-local" name="scheduled_at" class="form-control" required>
  </div>

  <div class="mb-2">
    <label>Fee (optional)</label>
    <input type="number" step="0.01" name="fee" class="form-control">
  </div>

  <button class="btn btn-primary">Create Appointment</button>
</form>

<script>
$('#clinic').on('change', function(){
  let id = $(this).val();
  $('#doctor').html('<option>Loading...</option>');
  $.get('/api/clinics/'+id+'/doctors', function(res){
    let html = '<option value="">Select</option>';
    res.forEach(d => { html += `<option value="${d.id}">${d.name} — ${d.consultation_fee}</option>`; });
    $('#doctor').html(html);
  });
});
</script>
@endsection
