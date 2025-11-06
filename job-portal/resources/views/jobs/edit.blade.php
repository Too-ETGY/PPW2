@extends('layouts.master')

@section('title', 'Edit Job (Admin)')

@section('content')
    <div class="container">
        <h2>Edit Lowongan</h2>

        <form action="{{ route('jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="text" name="title" placeholder="Judul Lowongan" class="form-control mb-2" value="{{ old('title', $job->title) }}">
            <textarea name="description" placeholder="Deskripsi" class="form-control mb-2">{{ old('description', $job->description) }}</textarea>
            <input type="text" name="location" placeholder="Lokasi" class="form-control mb-2" value="{{ old('location', $job->location) }}">
            <input type="text" name="company" placeholder="Nama Perusahaan" class="form-control mb-2" value="{{ old('company', $job->company) }}">
            <input type="number" name="salary" placeholder="Gaji" class="form-control mb-2" value="{{ old('salary', $job->salary) }}">
            <input type="text" name="job_type" placeholder="Jenis Pekerjaan" class="form-control mb-2" value="{{ old('job_type', $job->job_type) }}">
            <input type="file" name="logo" class="form-control mb-2">

            @if($job->logo)
                <div style="margin-bottom:12px">
                    <strong>Logo saat ini:</strong>
                    <div>
                        <img src="{{ asset('storage/' . $job->logo) }}" alt="{{ $job->company }} logo" width="120" style="display:block;margin-top:8px;border:1px solid #e5e7eb;padding:6px;background:#fff;">
                    </div>
                </div>
            @endif

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a class="btn btn-secondary" href="{{ route('jobs.index') }}">Back</a>
        </form>
    </div>
@endsection
