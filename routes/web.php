<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Handle employees
Route::resource('/employees', EmployeeController::class);

// Resource routes for Task management
Route::resource('/tasks', TaskController::class);
Route::get('tasks/done/{id}', [TaskController::class, 'done'])->name('tasks.done');
Route::get('tasks/pending/{id}', [TaskController::class, 'pending'])->name('tasks.pending');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
