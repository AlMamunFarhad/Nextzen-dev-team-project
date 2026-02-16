@extends('layouts.app') <!-- অথবা যেকোনো layout file -->

@section('content')
<div class="max-w-md mx-auto mt-10">
    <!-- Clinic Dropdown -->
    <select id="clinicSelect" class="border p-2 rounded w-full">
        <option value="">Select Clinic</option>
        @foreach($clinics as $clinic)
            <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
        @endforeach
    </select>

    <!-- Doctor Dropdown -->
    <select id="doctorSelect" class="border p-2 rounded w-full mt-2">
        <option value="">Select Doctor</option>
    </select>
</div>

<script>
document.getElementById('clinicSelect').addEventListener('change', function() {
    const clinicId = this.value;
    const doctorSelect = document.getElementById('doctorSelect');
    doctorSelect.innerHTML = '<option>Loading...</option>';

    if(clinicId) {
        fetch(`/clinics/${clinicId}/doctors`)
            .then(res => res.json())
            .then(data => {
                doctorSelect.innerHTML = '<option value="">Select Doctor</option>';
                data.forEach(doctor => {
                    const option = document.createElement('option');
                    option.value = doctor.id;
                    option.textContent = `${doctor.name} - ${doctor.consultation_fee}৳`;
                    doctorSelect.appendChild(option);
                });
            })
            .catch(err => {
                console.error(err);
                doctorSelect.innerHTML = '<option value="">Error loading doctors</option>';
            });
    } else {
        doctorSelect.innerHTML = '<option value="">Select Doctor</option>';
    }
});
</script>
@endsection



