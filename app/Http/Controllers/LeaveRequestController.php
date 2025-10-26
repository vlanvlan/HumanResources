<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\Employee;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $leaveRequests = LeaveRequest::all();
        return view('leave-requests.index', compact('leaveRequests'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('leave-requests.create', compact('employees'));
    }

    // Store new leave request
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'reason' => 'required|string|max:1000',
        ]);

        $request->merge([
            'status' => 'pending', // Default status
        ]);

        LeaveRequest::create($request->all());
        return redirect()->route('leave-requests.index')->with('success', 'Leave request created successfully.');
    }

    // Edit leave request
    public function edit(LeaveRequest $leaveRequest)
    {
        $employees = Employee::all();
        return view('leave-requests.edit', compact('leaveRequest', 'employees'));
    }

    // Update leave request
    public function update(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'reason' => 'required|string|max:1000',
        ]);

        $leaveRequest->update($request->all());
        return redirect()->route('leave-requests.index')->with('success', 'Leave request updated successfully.');
    }

    // Approve leave request
    public function approve($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->update(['status' => 'approved']);
        return redirect()->route('leave-requests.index')->with('success', 'Leave request approved successfully.');
    }

    // Reject leave request
    public function reject($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->update(['status' => 'rejected']);
        return redirect()->route('leave-requests.index')->with('success', 'Leave request rejected successfully.');
    }

    // Delete leave request
    public function destroy(LeaveRequest $leaveRequest)
    {
        $leaveRequest->delete();
        return redirect()->route('leave-requests.index')->with('success', 'Leave request deleted successfully.');
    }

}
