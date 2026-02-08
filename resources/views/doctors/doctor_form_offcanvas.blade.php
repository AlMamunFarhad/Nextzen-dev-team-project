@push('styles')
    <style>
        .input-group-merge .form-control {
            border: 1px solid #d9dee3;
        }

        .offcanvas :focus {
            outline: none !important;
            box-shadow: none !important;
        }
    </style>
@endpush

<div class="col-lg-3 col-md-6 mb-3">
    <div class="mt-3">

        {{-- <button class="btn btn-primary text-end" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd"
            aria-controls="offcanvasEnd" onclick="openDoctorForm(null)">
            Add New Doctor
        </button> --}}
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

            <div class="offcanvas-body my-auto mx-0 flex-grow-0">

                <form action="{{ route('doctors.store') }}" method="POST" id="doctorForm">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="specialization">Specialization</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-user"></i></span>
                            <input type="text" name="specialization" class="form-control" id="specialization"
                                placeholder="Cardiology..." />
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
                            <input type="number" name="fee" id="fee" class="form-control"
                                placeholder="100..." />
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


@push('scripts')
    <script>
        // Ensure offcanvas always starts clean
        document.addEventListener('DOMContentLoaded', function() {
            const offcanvasEl = document.getElementById('offcanvasEnd');

            // When offcanvas hides, reset form and remove _method
            offcanvasEl.addEventListener('hidden.bs.offcanvas', function() {
                try {
                    form.reset();
                    const oldMethod = form.querySelector('input[name="_method"]');
                    if (oldMethod) oldMethod.remove();
                    // reset submit button text/state
                    submitBtn.disabled = false;
                    submitBtn.innerText = originalText;
                    titleEl.innerText = 'Add New Doctor';
                    form.action = storeUrl;
                } catch (e) {
                    console.warn(e);
                }
            });
        });


        const storeUrl = "{{ route('doctors.store') }}"; // create
        const baseDoctorsUrl = "{{ url('doctors') }}"; // update -> /doctors/{id}

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
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(async res => {
                    if (!res.ok) {
                        const err = await res.json().catch(() => ({
                            message: 'Failed to fetch'
                        }));
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
                    const data = await res.json().catch(() => ({}));
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
        /* Delete doctor via AJAX without page refresh */

        function deleteDoctor(id) {
            if (!confirm('Are you sure you want to delete this doctor?')) return;

            fetch(`${baseDoctorsUrl}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    }
                })
                .then(async res => {
                    const data = await res.json().catch(() => ({}));
                    if (!res.ok) throw data;
                    return data;
                })
                .then(data => {
                    alert(data.message ?? 'Doctor deleted successfully!');

                    // Row DOM thekei remove
                    const row = document.getElementById(`doctorRow${id}`);
                    if (row) row.remove();

                    // **Important**: Delete korleo offcanvas open korar kono code nai
                })
                .catch(err => {
                    console.error(err);
                    alert(err.message ?? 'Something went wrong while deleting!');
                });
        }


        document.addEventListener('DOMContentLoaded', function() {
            const offcanvasEl = document.getElementById('offcanvasEnd');

            offcanvasEl.addEventListener('hidden.bs.offcanvas', function() {

                // 🔥 Remove backdrop manually
                document.querySelectorAll('.offcanvas-backdrop').forEach(el => el.remove());

                // 🔥 Unlock body scroll
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';

                // 🔥 Remove focus
                if (document.activeElement) {
                    document.activeElement.blur();
                }
            });
        });
    </script>
@endpush
