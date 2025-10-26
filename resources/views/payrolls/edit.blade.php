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
                <h3>Payroll</h3>
                <p class="text-subtitle text-muted">Handle Employee Payroll</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Payroll</li>
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
                    Edit payroll
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

                <form action="{{ route('payrolls.update', $payroll->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="" class="form-label">Employee</label>
                        <select name="employee_id" id="employee_id" class="form-control @error('employee_id') is-invalid @enderror" required>
                            <option value="">-- Select Employee --</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id', $payroll->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->fullname }}</option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Salary</label>
                        <input type="number" class="form-control" name="salary" value="{{ old('salary', $payroll->salary) }}" required>
                        @error('salary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Deductions</label>
                        <input type="number" class="form-control" name="deductions" value="{{ old('deductions', $payroll->deductions) }}" required>
                        @error('deductions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Bonuses</label>
                        <input type="number" class="form-control" name="bonuses" value="{{ old('bonuses', $payroll->bonuses) }}" required>
                        @error('bonuses')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Net Salary</label>
                        <input type="number" step="0.01" id="net_salary" class="form-control @error('net_salary') is-invalid @enderror" name="net_salary" value="{{ old('net_salary') }}" readonly required>
                        @error('net_salary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Pay Date</label>
                        <input type="date" class="form-control date" name="pay_date" value="{{ old('pay_date', $payroll->pay_date) }}" required>
                        @error('pay_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">Back to List</a>

                </form>

            </div>
        </div>

    </section>
</div>

{{-- Auto-calculate Net Salary --}}
<script>
    (function(){
        const salary = document.querySelector('input[name="salary"]');
        const deductions = document.querySelector('input[name="deductions"]');
        const bonuses = document.querySelector('input[name="bonuses"]');
        const net = document.querySelector('input[name="net_salary"]');
        if (!net || !salary) return;

        function val(e){ const n = parseFloat((e && e.value) || 0); return isFinite(n) ? n : 0; }
        function compute(){
            const result = val(salary) - val(deductions) + val(bonuses);
            net.value = Number.isFinite(result) ? result.toFixed(2) : '';
        }

        ['input','change'].forEach(evt=>{
            [salary, deductions, bonuses].forEach(f => { if (f) f.addEventListener(evt, compute); });
        });

        if (!net.value) compute();
    })();
</script>

@endsection
