<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\LeaveRequestController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('role:Admin');

    // Handle employees
    Route::resource('/employees', EmployeeController::class)->middleware('role:Admin');

    // Handle departments
    Route::resource('/departments', DepartmentController::class)->middleware('role:Admin');

    // Handle roles
    Route::resource('/roles', RoleController::class)->middleware('role:Admin');

    // Handle presences
    Route::resource('/presences', PresenceController::class)->middleware('role:Admin');

    // Handle payrolls
    Route::resource('/payrolls', PayrollController::class)->middleware('role:Admin');

    // Handle leaves
    Route::resource('/leave-requests', LeaveRequestController::class);
    Route::get('leave-requests/approve/{id}', [LeaveRequestController::class, 'approve'])->name('leave-requests.approve')->middleware('role:Admin');
    Route::get('leave-requests/reject/{id}', [LeaveRequestController::class, 'reject'])->name('leave-requests.reject')->middleware('role:Admin');

    // Resource routes for Task management
    Route::resource('/tasks', TaskController::class);
    Route::get('tasks/done/{id}', [TaskController::class, 'done'])->name('tasks.done')->middleware('role:Admin');
    Route::get('tasks/pending/{id}', [TaskController::class, 'pending'])->name('tasks.pending')->middleware('role:Admin');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
