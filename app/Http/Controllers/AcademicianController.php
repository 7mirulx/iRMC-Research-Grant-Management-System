<?php

namespace App\Http\Controllers;

use App\Models\Academician;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AcademicianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $academicians = Academician::all();
        return view('academicians.index', compact('academicians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('academicians.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_number' => 'required|unique:academicians',
            'name' => 'required',
            'email' => 'required|email|unique:academicians',
            'position' => 'required',
            'college' => 'required',
            'department' => 'required'
        ]);

        // Create the academician
        $academician = Academician::create($validated);

        // Create corresponding user account with default password
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make('password'), // Default password is 'password'
            'role' => 'academician',
            'academician_id' => $academician->id
        ]);

        return redirect()->route('academicians.index')
            ->with('success', 'Academician created successfully. Default password is "password"');
    }

    /**
     * Display the specified resource.
     */
    public function show(Academician $academician)
    {
        return view('academicians.show', compact('academician'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Academician $academician)
    {
        return view('academicians.edit', compact('academician'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Academician $academician)
    {
        $validated = $request->validate([
            'staff_number' => 'required|unique:academicians,staff_number,' . $academician->id,
            'name' => 'required',
            'email' => 'required|email|unique:academicians,email,' . $academician->id,
            'college' => 'required',
            'department' => 'required',
            'position' => 'required|in:Professor,Associate Professor,Senior Lecturer,Lecturer'
        ]);

        $academician->update($validated);
        return redirect()->route('academicians.index')->with('success', 'Academician updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Academician $academician)
    {
        // Delete associated user first
        if ($academician->user) {
            $academician->user->delete();
        }
        
        $academician->delete();
        
        return redirect()->route('academicians.index')
            ->with('success', 'Academician deleted successfully.');
    }
}
