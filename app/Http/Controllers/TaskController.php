<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Employee;



class TaskController extends Controller
{
    // Menampilkan daftar semua task
    public function index()
    {
        $tasks = Task::all();

        return view('tasks.index', compact('tasks'));
    }

    // Menampilkan form untuk membuat task baru
    public function create()
    {
        $employees = Employee::all();

        return view('tasks.create', compact('employees'));
    }

    // Menyimpan task baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'assigned_to' => 'required',
            'due_date' => 'required|date',
            'status' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Jika Berhasil divalidasi
        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $employees = Employee::all();

        return view('tasks.edit', compact('task', 'employees'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'assigned_to' => 'required',
            'due_date' => 'required|date',
            'status' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Jika Berhasil divalidasi, maka update task
        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function done(int $id)
    {
        $task = Task::find($id);
        $task->update(['status' => 'done']);

        return redirect()->route('tasks.index')->with('success', 'Task marked as done.');
    }

    public function pending(int $id)
    {
        $task = Task::find($id);
        $task->update(['status' => 'pending']);

        return redirect()->route('tasks.index')->with('success', 'Task marked as pending.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

}
