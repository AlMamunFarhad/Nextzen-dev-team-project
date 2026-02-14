<?php

namespace App\Http\Controllers\Doctors;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorRequest;
use App\Models\Doctor;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::with('user', 'schedules')->paginate(12);
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctorRequest $r)
    {
        $data = $r->validated();
        $data['user_id'] = auth()->id();
        $doctor = Doctor::create($data);
        return response()->json(['success' => true, 'message' => 'Doctor created successfully!', 'doctor' => $doctor], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return $doctor->load('user', 'schedules.slots');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        // $this->authorize('update', $doctor);
        return response()->json($doctor);
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(StoreDoctorRequest $r, Doctor $doctor)
    {
        $this->authorize('update', $doctor); // optional
        $data = $r->validated();
        $data['status'] = $r->has('status') && $r->status == 1 ? 1 : 0;
        $doctor->update($data);
        return response()->json(['success' => true, 'message' => 'Doctor updated successfully!', 'doctor' => $doctor]);
    }

    /**
     * Remove the specified resource from storage.
     */


    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return response()->json(['success' => true, 'message' => 'Doctor deleted successfully!']);
    }
}
