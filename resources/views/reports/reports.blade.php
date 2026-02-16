@extends('admin')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Reports /</span> Analytics</h4>
        <div class="row">
            <div class="col-md-3">
                <div class="card p-4">
                    <h4>Last 30 Days Revenue</h4>
                    <h2>{{ $revenue }} BDT</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-4">
                    <h4>Today's Appointments</h4>
                    <h2>{{ $todayAppointments->count() }}</h2>
                </div>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Doctor</th>
                            <th>Commission Due</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($report as $row)
                            <tr>
                                <td>{{ $row->doctor->name }}</td>
                                <td>{{ $row->due }} BDT</td>
                            </tr>
                        @endforeach
                        {{-- tr> --}}
                            <td>Dr. John Doe</td>
                            <td>5000 BDT</td>
                    </tbody>
                </table>

            </div>
        </div>
    @endsection
