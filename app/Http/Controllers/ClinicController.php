<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clinics = Clinic::withCount('doctors')->latest()->get();
        return view('clinics.index', compact('clinics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('clinics.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string|max:500', 
            'phone'   => 'required|string|digits:11|regex:/^01[3-9][0-9]{8}$/',
        ]);

        Clinic::create($request->all());

        return redirect()->route('clinics.index')->with('success', 'Clinic Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clinic $clinic)
    {
        return view('clinics.edit', compact('clinic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clinic $clinic)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'nullable|email'
        ]);

        $clinic->update($request->all());

        return redirect()->route('clinics.index')->with('success', 'Clinic Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Clinic $clinic)
    {
        $clinic->delete();

        return redirect()->route('clinics.index')->with('success', 'Clinic Deleted Successfully');
    }

}
