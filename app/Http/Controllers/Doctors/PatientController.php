<?php

namespace App\Http\Controllers\Doctors;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Patient::with('user')->paginate(20);
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
    public function store(Request $r)
    {
        $r->validate(['user_id' => 'required|exists:users,id', 'age' => 'nullable|integer', 'gender' => 'nullable|in:male,female,other']);
        $patient = Patient::create($r->only(['user_id', 'age', 'gender', 'address']));
        return response()->json($patient, 201);
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
        $patient->update($r->only(['age', 'gender', 'address']));
        return response()->json($patient);
    }


    public function destroy(Patient $patient)
    {
        $patient->delete();
        return response()->noContent();
    }
}
