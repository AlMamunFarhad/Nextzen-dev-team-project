@extends('admin')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <!-- Striped Rows -->

                <a href="{{ route('clinics.create') }}" class="btn btn-primary mb-4">Add Clinic</a>

                <div class="card">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Total Doctors</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach($clinics as $clinic)
                                    <tr>
                                        <td>{{ $clinic->name }}</td>
                                        <td>{{ $clinic->phone }}</td>
                                        <td>{{ $clinic->doctors_count }}</td>
                                        <td>
                                            <a class="btn btn-warning" href="{{ route('clinics.edit',$clinic->id) }}">Edit</a>

                                            <form class="delete-form d-inline-flex btn btn-danger" action="{{ route('clinics.destroy',$clinic->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--/ Striped Rows -->
            </div>
        </div>

    </div>
@endsection
