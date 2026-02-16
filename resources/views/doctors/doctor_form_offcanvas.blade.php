@push('styles')
    <style>
        .input-group-merge .form-control {
            border: 1px solid #d9dee3;
        }

        .offcanvas *:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        .invalid-consultation_feedback {
            display: block;
            color: #dc3545;
            margin-top: .25rem;
            font-size: .875rem;
        }

        .is-invalid {
            box-shadow: none !important;
            border-color: inherit !important;
        }

        .offcanvas-body {
            overflow-y: auto;
            padding-bottom: 1rem;
        }
    </style>
@endpush

<div class="col-lg-3 col-md-6 mb-3">
    <div class="mt-3">
        <button type="button" class="btn btn-primary" onclick="openDoctorForm(null)">
            Add New Doctor
        </button>

        <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvasEnd"
            aria-labelledby="offcanvasEndLabel" style="width: 30%">
            <div class="offcanvas-header">
                <h5 id="offcanvasEndLabel" class="offcanvas-title"></h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">
                <form action="{{ route('doctors.store') }}" method="POST" id="doctorForm">
                    @csrf
                    <input type="hidden" name="doctor_id" id="doctor_id">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    {{-- NAME FIELD ADDED --}}
                    <div class="mb-3">
                        <label class="form-label" for="name">Doctor Name</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-user"></i></span>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Dr. John Doe..." />
                            <div class="invalid-consultation_feedback"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="specialization">Specialization</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-user"></i></span>
                            <input type="text" name="specialization" class="form-control" id="specialization"
                                placeholder="Cardiology..." />
                            <div class="invalid-consultation_feedback"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="experience">Experience (Years)</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-buildings"></i></span>
                            <input type="text" name="experience" id="experience" class="form-control"
                                placeholder="5 yrs..." />
                            <div class="invalid-consultation_feedback"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="consultation_fee">Consultation consultation_fee</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                            <input type="number" step="0.01" name="consultation_fee" id="consultation_fee" class="form-control"
                                placeholder="100..." />
                            <span class="input-group-text">$</span>
                            <div class="invalid-consultation_feedback"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="bio">Bio</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-comment"></i></span>
                            <textarea name="bio" id="bio" class="form-control"
                                placeholder="Briefly tell about your expertise and experience..."></textarea>
                            <div class="invalid-consultation_feedback"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="status">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" id="status" value="1" checked>
                            <label class="form-check-label" for="status">Active</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" id="doctorSubmitBtn">
                        Save Profile
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Global Toast -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 2000">
    <div id="globalToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
        aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>


@push('scripts')
<script>
const form = document.getElementById('doctorForm');
const submitBtn = document.getElementById('doctorSubmitBtn');
const titleEl = document.getElementById('offcanvasEndLabel');
const offcanvasEl = document.getElementById('offcanvasEnd');
const storeUrl = "{{ route('doctors.store') }}";
const baseDoctorsUrl = "{{ url('doctors') }}";

const ORIGINAL_BTN_HTML = submitBtn.innerHTML;

// ===============================
// TOAST
// ===============================
function showToast(message, type = 'success') {
    const toastEl = document.getElementById('globalToast');
    const toastMsg = document.getElementById('toastMessage');

    toastEl.classList.remove('text-bg-success', 'text-bg-danger', 'text-bg-warning', 'text-bg-info');
    toastEl.classList.add(`text-bg-${type}`);
    toastMsg.innerText = message;

    new bootstrap.Toast(toastEl, { delay: 3000 }).show();
}

// ===============================
// HELPERS: clear/show errors
// ===============================
function clearErrors() {
    form.querySelectorAll('.invalid-consultation_feedback').forEach(el => el.innerText = '');
    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
}

function findconsultation_feedbackElementFor(input) {
    const group = input.closest('.input-group') || input.parentElement;
    if (!group) return null;
    return group.querySelector('.invalid-consultation_feedback') || input.nextElementSibling;
}

function showErrors(errors) {
    Object.keys(errors).forEach(field => {
        const input = form.querySelector(`[name="${field}"]`);
        if (!input) return;
        const consultation_feedback = findconsultation_feedbackElementFor(input);
        if (consultation_feedback) consultation_feedback.innerText = errors[field][0];
    });
}

form.querySelectorAll('input, textarea').forEach(input => {
    input.addEventListener('input', () => {
        const fb = findconsultation_feedbackElementFor(input);
        if (fb) fb.innerText = '';
    });
});

// ===============================
// OFFCANVAS RESET
// ===============================
offcanvasEl.addEventListener('hidden.bs.offcanvas', () => {
    form.reset();
    const method = form.querySelector('input[name="_method"]');
    if (method) method.remove();

    // remove doctor_id hidden if present
    const did = form.querySelector('input[name="doctor_id"]');
    if (did) did.value = '';

    // ensure status fallback input removed (we'll add before submit)
    const statusFallback = form.querySelector('input[name="status_hidden_fallback"]');
    if (statusFallback) statusFallback.remove();

    submitBtn.disabled = false;
    submitBtn.innerHTML = ORIGINAL_BTN_HTML;

    titleEl.innerText = 'Add New Doctor';
    form.action = storeUrl;

    document.querySelectorAll('.offcanvas-backdrop').forEach(el => el.remove());
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';

    clearErrors();
});

// ===============================
// OPEN FORM (CREATE/EDIT)
// ===============================
function openDoctorForm(doctor = null) {
    const offcanvas = bootstrap.Offcanvas.getOrCreateInstance(offcanvasEl);

    form.reset();
    clearErrors();

    // remove old _method if any
    const oldMethod = form.querySelector('input[name="_method"]');
    if (oldMethod) oldMethod.remove();

    if (doctor) {
        // EDIT mode
        titleEl.innerText = 'Edit Doctor Profile';
        submitBtn.innerHTML = 'Update Profile';
        form.action = `${baseDoctorsUrl}/${doctor.id}`;

        // method spoofing for PUT
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);

        // set doctor_id hidden (optional)
        const doctorIdInput = form.querySelector('input[name="doctor_id"]');
        if (doctorIdInput) doctorIdInput.value = doctor.id;

        // populate fields
        form.querySelector('[name="name"]').value = doctor.name ?? '';
        form.querySelector('[name="specialization"]').value = doctor.specialization ?? '';
        form.querySelector('[name="experience"]').value = doctor.experience ?? '';
        form.querySelector('[name="consultation_fee"]').value = doctor.consultation_fee ?? '';
        form.querySelector('[name="bio"]').value = doctor.bio ?? '';

        // Populate status checkbox and label
        const statusInput = form.querySelector('[name="status"]');
        const statusLabel = form.querySelector('label[for="status"]');
        if (statusInput) {
            statusInput.checked = doctor.status ? true : false;
            if (statusLabel) statusLabel.innerText = doctor.status ? 'Active' : 'Inactive';
        }
    } else {
        // CREATE mode
        titleEl.innerText = 'Add New Doctor';
        submitBtn.innerHTML = ORIGINAL_BTN_HTML;
        form.action = storeUrl;

        const doctorIdInput = form.querySelector('input[name="doctor_id"]');
        if (doctorIdInput) doctorIdInput.value = '';

        const statusInput = form.querySelector('[name="status"]');
        const statusLabel = form.querySelector('label[for="status"]');
        if (statusInput) {
            statusInput.checked = true; // default active
            if (statusLabel) statusLabel.innerText = 'Active';
        }
    }

    offcanvas.show();
}

// dynamic label update on toggle
const statusCheckbox = form.querySelector('[name="status"]');
if (statusCheckbox) {
    statusCheckbox.addEventListener('change', function() {
        const statusLabel = form.querySelector('label[for="status"]');
        if (statusLabel) statusLabel.innerText = this.checked ? 'Active' : 'Inactive';
    });
}

// ===============================
// FETCH DOCTOR (for edit)
// ===============================
function fetchDoctor(id) {
    fetch(`${baseDoctorsUrl}/${id}/edit`, {
        headers: { 'Accept': 'application/json' }
    })
    .then(async res => {
        const data = await res.json().catch(() => null);
        if (!res.ok) throw data || { message: 'Failed to fetch' };
        return data;
    })
    .then(doctorData => openDoctorForm(doctorData))
    .catch(err => showToast(err?.message || 'Failed to load doctor', 'danger'));
}

// ===============================
// CREATE/UPDATE AJAX
// ===============================
form.addEventListener('submit', function(e) {
    e.preventDefault();
    clearErrors();

    // Ensure a hidden fallback is present so unchecked checkbox still sends 0
    // We'll name it 'status_hidden_fallback' so it doesn't conflict with actual 'status'
    let fallback = form.querySelector('input[name="status_hidden_fallback"]');
    if (!fallback) {
        fallback = document.createElement('input');
        fallback.type = 'hidden';
        fallback.name = 'status_hidden_fallback';
        form.appendChild(fallback);
    }
    // if checkbox exists, set fallback to 0 and, if checked, we'll send status=1 as well
    const checkbox = form.querySelector('input[name="status"]');
    if (checkbox) {
        fallback.value = checkbox.checked ? '1' : '0';

        let existingStatusHidden = form.querySelector('input[name="status_hidden_for_submit"]');
        if (existingStatusHidden) existingStatusHidden.remove();

        const statusHidden = document.createElement('input');
        statusHidden.type = 'hidden';
        statusHidden.name = 'status';
        statusHidden.value = checkbox.checked ? '1' : '0';
        statusHidden.setAttribute('data-generated', 'true');
        statusHidden.classList.add('d-none');
        statusHidden.name = 'status';
        statusHidden.setAttribute('data-generated', '1');

        form.appendChild(statusHidden);
    }

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';

    // Build FormData AFTER we updated/added default status hidden input
    const payload = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': form._token.value,
            'Accept': 'application/json'
        },
        body: payload
    })
    .then(async res => {
        const data = await res.json().catch(() => ({}));
        if (!res.ok) throw data;
        return data;
    })
    .then(data => {
        showToast(data.message || 'Saved', 'success');
        bootstrap.Offcanvas.getInstance(offcanvasEl).hide();
        location.reload();
    })
    .catch(err => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = ORIGINAL_BTN_HTML;

        if (err && err.errors) showErrors(err.errors);
        else showToast(err.message || 'Something went wrong!', 'danger');
    });
});

// ===============================
// DELETE - single implementation (use confirm or SweetAlert)
// ===============================
function deleteDoctor(id) {
    if (!confirm('Are you sure?')) return;

    fetch(`${baseDoctorsUrl}/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': form._token.value,
            'Accept': 'application/json'
        }
    })
    .then(async res => {
        const data = await res.json().catch(() => ({}));
        if (!res.ok) throw data;
        return data;
    })
    .then(data => {
        showToast(data.message || 'Doctor deleted successfully!', 'danger');
        document.getElementById(`doctorRow${id}`)?.remove();
    })
    .catch(() => showToast('Delete failed!', 'danger'));
}

</script>
@endpush


