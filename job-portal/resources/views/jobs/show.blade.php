@extends('layouts.master')

@section('title', 'Job Details ' . (auth()->check() && strtolower(auth()->user()->role) === 'admin' ? '(admin)' : ''))


@section('content')
<div class="container mb-3 d-flex justify-content-end">
    <a class="btn btn-secondary" href="{{ route('jobs.index') }}">Back</a>
</div>  

<div class="container">

    {{-- Job Header Section --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <img src="{{ asset('storage/' . $job->logo) }}"
             alt="{{ $job->company }} logo"
             width="120"
             class="border p-2 bg-white rounded">

        <div>
            <h2 class="mb-1">{{ $job->title }}</h2>

            @if (auth()->check() && strtolower(auth()->user()->role) === 'admin')
                <a href="{{ route('applications.filter', $job->id) }}" class="text-decoration-none fw-bold text-primary">
                    View Applicants →
                </a>
            @endif
        </div>
    </div>

    {{-- Application Status Box --}}
    @if($application)
        <div class="alert alert-info mt-3">
            <h5 class="mb-2">Your Application Status</h5>

            <p class="mb-1">
                <strong>Status:</strong>
                <span class="badge 
                    @switch($application->status)
                        @case('Pending') bg-warning @break
                        @case('Accepted') bg-success @break
                        @case('Rejected') bg-danger @break
                        @default bg-secondary
                    @endswitch
                ">
                    {{ $application->status }}
                </span>
            </p>

            @if($application->notes)
                <p class="mb-2"><strong>Notes:</strong> {{ $application->notes }}</p>
            @endif

            <a href="{{ asset('storage/' . $application->cv) }}" 
               class="btn btn-outline-primary btn-sm"
               download>
                Download Your CV
            </a>
        </div>
    @endif


    {{-- Job Details Card --}}
    <div class="card mt-4">
        <div class="card-body">

            <p><strong>Company:</strong> {{ $job->company }}</p>
            <p><strong>Description:</strong> {{ $job->description }}</p>
            <p><strong>Location:</strong> {{ $job->location }}</p>
            <p><strong>Salary:</strong> {{ $job->salary }}</p>
            <p><strong>Job Type:</strong> {{ $job->job_type }}</p>

            {{-- Application Form --}}
            <h5 class="mt-4">Apply for This Job</h5>
            <form action="{{ route('apply.store', $job->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="d-flex gap-2">

                @csrf

                <input type="file" 
                       name="cv"
                       class="form-control form-control-sm"
                       required
                       {{ (auth()->check() && strtolower(auth()->user()->role) === 'admin') || $application ? 'disabled' : '' }}>

                <button type="submit"
                        class="btn btn-primary btn-sm"
                        {{ (auth()->check() && strtolower(auth()->user()->role) === 'admin') || $application ? 'disabled' : '' }}>
                    Lamar
                </button>
            </form>

            @if(!$application)
                <small class="text-muted">Upload your CV in PDF format.</small>
            @endif

        </div>
    </div>

</div>
@endsection
