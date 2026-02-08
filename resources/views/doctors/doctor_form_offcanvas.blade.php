@push('styles')
<style>
.input-group-merge .form-control {
    border: 1px solid #d9dee3;
}
</style>
@endpush

<div class="col-lg-3 col-md-6 mb-3">
    <div class="mt-3">
        <button class="btn btn-primary text-end" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd"
            aria-controls="offcanvasEnd">
            Add New Doctor
        </button>

        <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvasEnd"
            aria-labelledby="offcanvasEndLabel" style="width: 30%">
            <div class="offcanvas-header">
                <h5 id="offcanvasEndLabel" class="offcanvas-title"></h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>

            <div class="offcanvas-body my-auto mx-0 flex-grow-0">
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="{{ route('doctors.store') }}" method="POST" id="doctorForm">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="specialization">Specialization</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                                    <input type="text" name="specialization" class="form-control"
                                        id="specialization" placeholder="Cardiology..." />
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="experience">Experience (Years)</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-buildings"></i></span>
                                    <input type="text" name="experience" id="experience" class="form-control"
                                        placeholder="5 yrs..." />
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="fee">Consultation Fee</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                                    <input type="text" name="fee" id="fee" class="form-control" placeholder="100..."/>
                                    <span class="input-group-text">$</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="bio">Bio</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-comment"></i></span>
                                    <textarea name="bio" id="bio" class="form-control"
                                        placeholder="Briefly tell about your expertise and experience..."></textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary" id="doctorSubmitBtn">Save Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
const storeUrl = "{{ route('doctors.store') }}"; // create
const baseDoctorsUrl = "{{ url('doctors') }}";    // update -> /doctors/{id}

const form = document.getElementById('doctorForm');
const submitBtn = document.getElementById('doctorSubmitBtn');
const titleEl = document.getElementById('offcanvasEndLabel');
let originalText = submitBtn?.innerText ?? 'Save Profile';

/* openDoctorForm: create (null) / edit (doctor object) */
function openDoctorForm(doctor = null) {
    const offcanvasEl = document.getElementById('offcanvasEnd');
    const offcanvas = new bootstrap.Offcanvas(offcanvasEl);

    form.reset();
    // remove old _method if present
    const oldMethod = form.querySelector('input[name="_method"]');
    if (oldMethod) oldMethod.remove();

    // default CREATE
    titleEl.innerText = 'Add New Doctor';
    submitBtn.innerText = 'Save Profile';
    form.action = storeUrl;

    if (doctor) {
        // EDIT
        titleEl.innerText = 'Edit Doctor Profile';
        submitBtn.innerText = 'Update Profile';
        form.action = `${baseDoctorsUrl}/${doctor.id}`;

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);

        // populate fields (ensure name attributes match)
        form.querySelector('[name="specialization"]').value = doctor.specialization ?? '';
        form.querySelector('[name="experience"]').value = doctor.experience ?? '';
        form.querySelector('[name="fee"]').value = doctor.fee ?? '';
        form.querySelector('[name="bio"]').value = doctor.bio ?? '';
    }

    offcanvas.show();
}

/* fetchDoctor: call controller and open form with data */
function fetchDoctor(id) {
    fetch(`${baseDoctorsUrl}/${id}/edit`, {
        headers: { 'Accept': 'application/json' }
    })
    .then(async res => {
        if (!res.ok) {
            const err = await res.json().catch(()=>({message:'Failed to fetch'}));
            throw err;
        }
        return res.json();
    })
    .then(doctor => {
        openDoctorForm(doctor);
    })
    .catch(err => {
        console.error(err);
        alert(err.message ?? 'Could not load doctor data.');
    });
}

/* Form submit handler (works for create and update using _method override) */
form.addEventListener('submit', function(e) {
    e.preventDefault();
    const methodInput = form.querySelector('input[name="_method"]');
    const method = methodInput ? methodInput.value : 'POST';
    const action = form.action;
    const formData = new FormData(form);

    submitBtn.disabled = true;
    submitBtn.innerText = method === 'PUT' ? 'Updating...' : 'Saving...';

    fetch(action, {
        method: 'POST', // Laravel expects POST + _method override
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(async res => {
        const data = await res.json().catch(()=> ({}));
        if (!res.ok) throw data;
        return data;
    })
    .then(data => {
        submitBtn.disabled = false;
        submitBtn.innerText = originalText;

        const offcanvasEl = document.getElementById('offcanvasEnd');
        const offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvasEl);
        if (offcanvasInstance) offcanvasInstance.hide();

        form.reset();

        // quick and safe: reload list so UI syncs. You can replace with smart row update.
        alert(data.message ?? 'Saved successfully!');
        location.reload();
    })
    .catch(err => {
        submitBtn.disabled = false;
        submitBtn.innerText = originalText;
        if (err.errors) {
            let messages = '';
            Object.values(err.errors).forEach(arr => messages += arr[0] + '\n');
            alert(messages);
        } else if (err.message) alert(err.message);
        else alert('Something went wrong.');
    });
});
</script>
@endpush



{{-- @push('scripts')
<script>
const storeUrl = "{{ route('doctors.store') }}"; // create
const baseDoctorsUrl = "{{ url('doctors') }}";    // update -> /doctors/{id}

/* openDoctorForm: create (null) / edit (doctor object) */
function openDoctorForm(doctor = null) {
    const offcanvasEl = document.getElementById('offcanvasEnd');
    const offcanvas = new bootstrap.Offcanvas(offcanvasEl);
    const form = document.getElementById('doctorForm');
    const submitBtn = document.getElementById('doctorSubmitBtn');
    const title = document.getElementById('offcanvasEndLabel');

    form.reset();
    const oldMethod = form.querySelector('input[name="_method"]');
    if (oldMethod) oldMethod.remove();

    // default CREATE
    title.innerText = 'Add New Doctor';
    submitBtn.innerText = 'Save Profile';
    form.action = storeUrl;

    if (doctor) {
        // EDIT
        title.innerText = 'Edit Doctor Profile';
        submitBtn.innerText = 'Update Profile';
        form.action = `${baseDoctorsUrl}/${doctor.id}`;

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);

        form.specialization.value = doctor.specialization ?? '';
        form.experience.value = doctor.experience ?? '';
        form.fee.value = doctor.fee ?? '';
        form.bio.value = doctor.bio ?? '';
    }

    offcanvas.show();
}



    fetch(form.action, {
        method: 'POST', // Laravel handles PUT via _method
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(async res => {
        const data = await res.json().catch(()=> ({}));
        if(!res.ok) throw data;
        return data;
    })
    .then(data => {
        submitBtn.disabled = false;
        submitBtn.innerText = originalText;

        const offcanvasEl = document.getElementById('offcanvasEnd');
        const offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvasEl);
        if(offcanvasInstance) offcanvasInstance.hide();

        form.reset();

        alert(data.message ?? 'Saved successfully!');
        // TODO: update table row if you want
    })
    .catch(err => {
        submitBtn.disabled = false;
        submitBtn.innerText = originalText;
        if(err.errors){
            let messages = '';
            Object.values(err.errors).forEach(arr => messages += arr[0] + '\n');
            alert(messages);
        } else if(err.message) alert(err.message);
        else alert('Something went wrong.');
    });

</script>
@endpush --}}


{{-- @push('styles')
    <style>
        .input-group-merge .form-control {
            border: 1px solid #d9dee3;
        }
    </style>
@endpush
<div class="col-lg-3 col-md-6 mb-3">
    <div class="mt-3">
        <button class="btn btn-primary text-end" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd"
            aria-controls="offcanvasEnd">
            Add New Doctor
        </button>
        <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvasEnd"
            aria-labelledby="offcanvasEndLabel" style="width: 30%">
            <div class="offcanvas-header">
                <h5 id="offcanvasEndLabel" class="offcanvas-title"></h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body my-auto mx-0 flex-grow-0">
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="{{ route('doctors.store') }}" method="POST" id="doctorForm">
                            @csrf
                               <input type="hidden" name="_method" id="formMethod" value="POST">
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-fullname">Specialization</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bx-user"></i></span>
                                    <input type="text" name="specialization" class="form-control"
                                        id="basic-icon-default-fullname" placeholder="Cardiology..."
                                        aria-label="Specialization" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-company">Experience (Years)</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-company2" class="input-group-text"><i
                                            class="bx bx-buildings"></i></span>
                                    <input type="text" name="experience" id="basic-icon-default-company"
                                        class="form-control" placeholder="5 yrs..." aria-label="Experience"
                                        aria-describedby="basic-icon-default-company2" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-email">Consultation Fee</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                                    <input type="text" name="fee" id="basic-icon-default-email"
                                        class="form-control" placeholder="100..." aria-label="Consultation Fee"
                                        aria-describedby="basic-icon-default-email2" />
                                    <span id="basic-icon-default-email2" class="input-group-text">$</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-message">Bio</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-message2" class="input-group-text"><i
                                            class="bx bx-comment"></i></span>
                                    <textarea id="basic-icon-default-message" class="form-control" name="bio"
                                        placeholder="Briefly tell about your expertise and experience..." aria-label="Bio"
                                        aria-label="Briefly tell about your expertise and experience" aria-describedby="basic-icon-default-message2"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="doctorSubmitBtn">Save Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@push('scripts')
<script>
/* base urls (blade evaluates on server) */
const storeUrl = "{{ route('doctors.store') }}";        // create
const baseDoctorsUrl = "{{ url('doctors') }}";         // for update -> /doctors/{id}

/* openDoctorForm: called for both create (null) and edit (doctor object) */
function openDoctorForm(doctor = null) {
    const offcanvasEl = document.getElementById('offcanvasEnd');
    const offcanvas = new bootstrap.Offcanvas(offcanvasEl);
    const form = document.getElementById('doctorForm');
    const submitBtn = document.getElementById('doctorSubmitBtn');
    const title = document.getElementById('offcanvasEndLabel');

    // reset & remove any old _method
    form.reset();
    const oldMethod = form.querySelector('input[name="_method"]');
    if (oldMethod) oldMethod.remove();

    // default create
    title.innerText = 'Add New Doctor';
    submitBtn.innerText = 'Save Profile';
    form.action = storeUrl;

    if (doctor) {
        // EDIT mode -> set action to update url and add _method = PUT
        title.innerText = 'Edit Doctor Profile';
        submitBtn.innerText = 'Update Profile';
        form.action = `${baseDoctorsUrl}/${doctor.id}`;

        // add method spoof input
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);

        // populate fields by name
        form.querySelector('[name="specialization"]').value = doctor.specialization ?? '';
        form.querySelector('[name="experience"]').value = doctor.experience ?? '';
        form.querySelector('[name="fee"]').value = doctor.fee ?? '';
        form.querySelector('[name="bio"]').value = doctor.bio ?? '';
    }

    offcanvas.show();
}


/* AJAX submit for both create & update */
document.getElementById('doctorForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = this;
    const submitBtn = document.getElementById('doctorSubmitBtn');
    const formData = new FormData(form);

    submitBtn.disabled = true;
    const originalText = submitBtn.innerText;
    submitBtn.innerText = originalText.includes('Update') ? 'Updating...' : 'Saving...';

    fetch(form.action, {
        method: 'POST', // always POST with method spoofing for PUT
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(async response => {
        const data = await response.json().catch(()=> ({}));
        if (!response.ok) throw data;
        return data;
    })
    .then(data => {
        // success: close, reset, optionally update UI
        submitBtn.disabled = false;
        submitBtn.innerText = originalText;

        // close offcanvas
        const offcanvasEl = document.getElementById('offcanvasEnd');
        const offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvasEl);
        if (offcanvasInstance) offcanvasInstance.hide();

        form.reset();

        // tiny success feedback (change to Toast/SweetAlert if you want)
        if (data.message) alert(data.message);
        else alert('Saved');

        // OPTIONAL: update the row in the table without reload
        // if you want, return data.doctor and update DOM here
    })
    .catch(error => {
        submitBtn.disabled = false;
        submitBtn.innerText = originalText;

        if (error && error.errors) {
            // show first validation message(s)
            let out = '';
            Object.values(error.errors).forEach(arr => { out += arr[0] + '\n'; });
            alert(out);
        } else if (error && error.message) {
            alert(error.message);
        } else {
            alert('Something went wrong');
        }
    });
});


// document.getElementById('doctorForm').addEventListener('submit', function (e) {
//     e.preventDefault();

//     const form = this;
//     const submitBtn = document.getElementById('doctorSubmitBtn');
//     const formData = new FormData(form);

//     submitBtn.disabled = true;
//     submitBtn.innerText = 'Saving...';

//     fetch(form.action, {
//         method: form.querySelector('input[name="_method"]') ? 'POST' : 'POST',
//         headers: {
//             'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
//             'Accept': 'application/json'
//         },
//         body: formData
//     })
//     .then(async response => {
//         if (!response.ok) {
//             const errorData = await response.json();
//             throw errorData;
//         }
//         return response.json();
//     })
//     .then(data => {
//         submitBtn.disabled = false;
//         submitBtn.innerText = 'Save Profile';

//         // close offcanvas
//         const offcanvasEl = document.getElementById('offcanvasEnd');
//         const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
//         offcanvas.hide();

//         form.reset();

//         // optional alert / toast
//         alert(data.message ?? 'Doctor saved successfully!');
//     })
//     .catch(error => {
//         submitBtn.disabled = false;
//         submitBtn.innerText = 'Save Profile';
//         if (error.errors) {
//             let messages = '';
//             Object.values(error.errors).forEach(errArr => {
//                 messages += errArr[0] + '\n';
//             });
//             alert(messages);
//         } else {
//             alert('Something went wrong. Try again.');
//         }
//     });
// });
</script>
@endpush







                      {{-- <!-- Large Modal -->
                      <div class="modal fade" id="largeModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel3">Modal title</h5>
                              <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                              ></button>
                            </div>
                            <div class="modal-body">
                               <form action="#" method="POST">
                            @csrf
                            {{-- @if ($method === 'PUT')
                                @method('PUT')
                            @endif --}}
                            {{-- <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-fullname">Specialization</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bx-user"></i></span>
                                    <input type="text" name="specialization" class="form-control"
                                        id="basic-icon-default-fullname" placeholder="Cardiology..."
                                        aria-label="Specialization" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-company">Experience (Years)</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-company2" class="input-group-text"><i
                                            class="bx bx-buildings"></i></span>
                                    <input type="text" name="experience" id="basic-icon-default-company"
                                        class="form-control" placeholder="5 yrs..." aria-label="Experience"
                                        aria-describedby="basic-icon-default-company2" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-email">Consultation Fee</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                                    <input type="text" name="fee" id="basic-icon-default-email"
                                        class="form-control" placeholder="100..." aria-label="Consultation Fee"
                                        aria-describedby="basic-icon-default-email2" />
                                    <span id="basic-icon-default-email2" class="input-group-text">$</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-message">Bio</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-message2" class="input-group-text"><i
                                            class="bx bx-comment"></i></span>
                                    <textarea id="basic-icon-default-message" class="form-control"
                                        placeholder="Briefly tell about your expertise and experience..." aria-label="Bio"
                                        aria-label="Briefly tell about your expertise and experience..." aria-describedby="basic-icon-default-message2"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Send</button>
                        </form>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Close
                              </button>
                              <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                          </div>
                        </div>
                      </div> --}}
