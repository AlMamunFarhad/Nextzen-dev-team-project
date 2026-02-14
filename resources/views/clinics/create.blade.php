@extends('admin')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <!-- / Content -->

                <a href="{{ route("clinics.index") }}" class="btn btn-dark">Back</a>
                <h2 class="mb-4 mt-4">Add Clinic</h2>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('clinics.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Clinic Name</label>
                                <input type="text" name="name" class="form-control" id="exampleFormControlInput1" value="{{ old('name') }}" placeholder="Badda Diagnostic">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" id="exampleFormControlInput1" value="{{ old('phone') }}" placeholder="Tpye Clinic Phone Number">
                            </div>

                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Address</label>
                                <textarea name="address" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ old('address') }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
