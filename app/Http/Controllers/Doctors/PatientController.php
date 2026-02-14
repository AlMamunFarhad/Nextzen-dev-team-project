<?php

namespace App\Http\Controllers\Doctors;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return view('patients.index', compact('users'));
    }

    public function data()
    {
        return Patient::with('user')->latest()->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $r)
    {
        $r->validate([
            'user_id' => 'required|exists:users,id|unique:patients,user_id',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:255',
        ]);

        $patient = Patient::create($r->only(['user_id', 'age', 'gender', 'address']));

        // Optional: eager load user relation for frontend
        $patient->load('user');

        return response()->json([
            'message' => 'Patient created successfully',
            'patient' => $patient,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return $patient->load('user', 'appointments');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $r, Patient $patient)
    {
        $patient->update($r->only(['user_id', 'age', 'gender', 'address']));

        return response()->json($patient);
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return response()->noContent();
    }
}
