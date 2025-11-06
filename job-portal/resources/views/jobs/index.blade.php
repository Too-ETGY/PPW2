@extends('layouts.master')

@section('title', 'Jobs (Admin)')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Job Listings</h2>
    <a href="{{ route('jobs.create') }}" class="btn btn-success mb-3">Tambah Lowongan</a>
    <div class="row g-3">
        @foreach($jobs as $job)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header">
                        @if($job->logo)
                            <div style="text-align: center; margin-bottom: 12px;">
                                <img src="{{ asset('storage/' . $job->logo) }}" alt="{{ $job->company }} logo" width="100" style="border:1px solid #e5e7eb;padding:6px;background:#fff;">
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $job->title }}</h5>
                        <p class="card-text text-muted">{{ $job->description }}</p>
                        <p class="small mb-1"><strong>Location:</strong> {{ $job->location }}</p>
                        <p class="small mb-1"><strong>Salary:</strong> {{ $job->salary }}</p>
                        <p class="small mb-1"><strong>Job Type:</strong> {{ $job->job_type }}</p>
                    </div>

                    <div class="card-footer bg-white border-0 d-flex justify-content-start">
                        <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-outline-success btn-sm">Edit</a>
                        <button 
                            class="btn btn-outline-danger btn-sm" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteModal{{ $job->id }}">
                            Delete
                        </button>
                    </div>
                </div>
            </div>

            <!-- Delete Modal -->
            <div class="modal fade" id="deleteModal{{ $job->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $job->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel{{ $job->id }}">Delete Job</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete <strong>{{ $job->title }}</strong>?
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