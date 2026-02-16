@extends('admin')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('doctors.doctor_form_offcanvas')
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <!-- Striped Rows -->
                <!-- / Content -->
                <div class="card">
                    <h5 class="card-header">Doctors List</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Doctor Name</th>
                                    <th>Specialization</th>
                                    <th>Experience</th>
                                    <th>Fee</th>
                                    <th>Bio</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($doctors as $doctor)
                                    <tr id="doctorRow{{ $doctor->id }}">
                                        <td>{{ $doctor->name }}</td>
                                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                            <strong>{{ $doctor->specialization }}</strong>
                                        </td>
                                        <td>{{ $doctor->experience }}</td>
                                        <td>{{ $doctor->fee }}</td>
                                        <td>{{ $doctor->bio }}</td>
                                        <td>{{ $doctor->user->name }}</td>
                                        <td>
                                            @if ($doctor->status)
                                                <span class="badge rounded-pill bg-label-info">Active</span>
                                            @else
                                                <span class="badge rounded-pill bg-label-warning">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <div>
                                                        <a class="dropdown-item" href="javascript:void(0);"
                                                            onclick="fetchDoctor({{ $doctor->id }})"><i
                                                                class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    </div>
                                                    <a class="dropdown-item" href="javascript:void(0);" type="button"
                                                        onclick="deleteDoctor({{ $doctor->id }})"><i
                                                            class="bx bx-trash me-1"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 d-flex justify-content-end" style="margin-bottom: 2em; margin-right: 1em;  ">
                        {{ $doctors->links() }}
                    </div>
                </div>
                <!--/ Striped Rows -->
            </div>
        </div>

    </div>
@endsection
