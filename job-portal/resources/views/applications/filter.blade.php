@extends('layouts.master')

@section('title', 'Applications List')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Applications</h2>

        {{-- Export button --}}
        <a 
            href="{{ isset($selectedJob) ? route('applications.export', ['job_id' => $selectedJob->id]) : route('applications.export') }}"
            class="btn btn-success">
            Export Excel
        </a>
    </div>

    {{-- Filter --}}
    <form action="" method="GET" class="mb-3">
        <label for="job" class="form-label">Filter by Job Vacancy</label>
        <select class="form-select" id="job"
                onchange="window.location.href=this.value">

            <option value="">-- Show All --</option>

            @foreach($jobs as $job)
                <option
                    value="{{ route('applications.filter', $job->id) }}"
                    {{ isset($selectedJob) && $selectedJob->id == $job->id ? 'selected' : '' }}
                >
                    {{ $job->title }} - {{ $job->company }}
                </option>
            @endforeach
        </select>
    </form>

    {{-- If filtered --}}
    @if(isset($selectedJob))
        <div class="alert alert-info">
            Showing applicants for: <strong>{{ $selectedJob->title }}</strong>
        </div>
    @endif

    {{-- Applications Table --}}
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>User</th>
                <th>Job Title</th>
                <th>Status</th>
                <th>CV</th>
            </tr>
        </thead>

        <tbody>
            @foreach($applications as $app)
                <tr>
                    <td>{{ $app->user->name }}</td>
                    <td>{{ $app->job->title }}</td>
                    <td>
                        <span class="badge 
                            @if($app->status == 'Pending') bg-warning
                            @elseif($app->status == 'Accepted') bg-success
                            @elseif($app->status == 'Rejected') bg-danger
                            @endif">
                            {{ $app->status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ asset('storage/' . $app->cv) }}" 
                           class="btn btn-primary btn-sm" 
                           download>
                           Download CV
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
