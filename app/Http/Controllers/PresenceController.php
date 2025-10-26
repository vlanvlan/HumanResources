<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presence;
use App\Models\Employee;

class PresenceController extends Controller
{
    public function index()
    {
        $presences = Presence::all();
        return view('presences.index', compact('presences'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('presences.create', compact('employees'));
    }

    // Store new presence record
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'status' => 'required|string|max:50',
            // accept nullable input from forms/APIs; we'll normalize below
            'check_in' => 'nullable',
            'check_out' => 'nullable',
        ]);

        Presence::create($request->all());
        return redirect()->route('presences.index')->with('success', 'Presence record created successfully.');
    }

    // Edit presence record
    public function edit(Presence $presence)
    {
        $employees = Employee::all();
        return view('presences.edit', compact('presence', 'employees'));
    }

    // Update presence record
    public function update(Request $request, Presence $presence)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'status' => 'required|string|max:50',
            'check_in' => 'nullable',
            'check_out' => 'nullable',
        ]);

        $presence->update($request->all());
        return redirect()->route('presences.index')->with('success', 'Presence record updated successfully.');
    }

    // Delete presence record
    public function destroy(Presence $presence)
    {
        $presence->delete();
        return redirect()->route('presences.index')->with('success', 'Presence record deleted successfully.');
    }
}
