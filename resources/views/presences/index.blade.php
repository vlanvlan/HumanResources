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
                <h3>Presence</h3>
                <p class="text-subtitle text-muted">Handle presence data</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Presence</li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Data
                </h5>
            </div>
            <div class="card-body">

                <div class="d-flex">
                    <a href="{{ route('presences.create')}}" class="btn btn-primary mb-3 ms-auto">New Presence</a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($presences as $presence)

                        <tr>
                            <td>{{ $presence->employee->fullname }}</td>
                            <td>{{ $presence->check_in }}</td>
                            <td>{{ $presence->check_out }}</td>
                            <td>{{ $presence->date }}</td>
                            <td>
                                @if ($presence->status == 'present')
                                    <span class="badge bg-success">Present</span>
                                @elseif ($presence->status == 'absent')
                                    <span class="badge bg-danger">Absent</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($presence->status) }}</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('presences.edit', $presence->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('presences.destroy', $presence->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>

                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>

@include('components.sweet-alert-delete')

@endsection
