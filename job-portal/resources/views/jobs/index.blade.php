@extends('layouts.master')

@section('title', 'Jobs')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Job Listings</h2>
    <p class="text-muted mb-3 text-center">Daftar Lowongan.</p>

    {{-- Admin-only Add Job button --}}
    @if(auth()->check() && strtolower(auth()->user()->role) === 'admin')
        <div class="d-flec justify-content-between">
            <a href="{{ route('jobs.create') }}" class="btn btn-success mb-3">Tambah Lowongan</a>
            <a href="{{ route('applications.index') }}" class="btn btn-primary mb-3">Daftar Pelamar</a>
        </div>
    @endif

    <div class="row g-3">
        @foreach($jobs as $job)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">

                    @if($job->logo)
                        <div class="text-center pt-3">
                            <img src="{{ asset('storage/' . $job->logo) }}" 
                                 alt="{{ $job->company }} logo" 
                                 width="100"
                                 class="border p-2 bg-white rounded">
                        </div>
                    @endif

                    <div class="card-body">
                        <a href="/jobs/{{ $job->id }}" class="card-title fs-5 text-decoration-none">{{ $job->title }}</a>
                        <p class="card-text text-muted">{{ $job->description }}</p>
                        <p class="small mb-1"><strong>Location:</strong> {{ $job->location }}</p>
                        <p class="small mb-1"><strong>Salary:</strong> {{ $job->salary }}</p>
                        <p class="small mb-1"><strong>Job Type:</strong> {{ $job->job_type }}</p>
                    </div>

                    <div class="card-footer bg-white border-0">
                        {{-- ADMIN BUTTONS --}}
                        @if(auth()->check() && strtolower(auth()->user()->role) === 'admin')
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('jobs.edit', $job->id) }}" 
                                    class="btn btn-outline-success btn-sm">Edit</a>

                                <button class="btn btn-outline-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $job->id }}">
                                    Delete
                                </button>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            {{-- Delete Modal --}}
            <div class="modal fade" id="deleteModal{{ $job->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Job</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            Are you sure you want to delete 
                            <strong>{{ $job->title }}</strong>?
                        </div>

                        <div class="modal-footer">
                            <form action="{{ route('jobs.destroy', $job->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        @endforeach
    </div>
</div>
@endsection
