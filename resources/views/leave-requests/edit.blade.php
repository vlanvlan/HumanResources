@extends('layouts.dashboard')

@section('content')

<header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Leave Request</h3>
                <p class="text-subtitle text-muted">Handle Leave Request Data</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Leave Request</li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Edit Leave Request
                </h5>
            </div>
            <div class="card-body">

                {{-- Display Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('leave-requests.update', $leaveRequest->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="" class="form-label">Employee</label>
                        <select name="employee_id" id="employee_id" class="form-control @error('employee_id') is-invalid @enderror" required>
                            <option value="">-- Select Employee --</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" {{ $leaveRequest->employee_id == $employee->id ? 'selected' : '' }}>{{ $employee->fullname }}</option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Leave Type</label>
                        <select name="leave_type" id="leave_type" class="form-control @error('leave_type') is-invalid @enderror" required>
                            <option value="sick" {{ $leaveRequest->leave_type == 'sick' ? 'selected' : '' }}>Sick Leave</option>
                            <option value="vacation" {{ $leaveRequest->leave_type == 'vacation' ? 'selected' : '' }}>Vacation Leave</option>
                            <option value="personal" {{ $leaveRequest->leave_type == 'personal' ? 'selected' : '' }}>Personal Leave</option>
                            <option value="maternity" {{ $leaveRequest->leave_type == 'maternity' ? 'selected' : '' }}>Maternity Leave</option>
                        </select>
                        @error('leave_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Start Date</label>
                        <input type="date" class="form-control date" name="start_date" value="{{ $leaveRequest->start_date }}" required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">End Date</label>
                        <input type="date" class="form-control date" name="end_date" value="{{ $leaveRequest->end_date }}" required>
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Reason</label>
                        <textarea name="reason" class="form-control @error('reason') is-invalid @enderror" required>{{ $leaveRequest->reason }}</textarea>
                        @error('reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('leave-requests.index') }}" class="btn btn-secondary">Back to List</a>

                </form>

            </div>
        </div>

    </section>
</div>

@endsection
