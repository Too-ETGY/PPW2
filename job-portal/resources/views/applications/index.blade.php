@extends('layouts.master')

@section('title', 'Daftar Pelamar')

@section('content')
<div class="container py-4">

    <h2 class="mb-4 fw-bold text-center">Daftar Pelamar</h2>

    <p class="text-muted mb-3 text-center">Kelola daftar pelamar yang tersedia.</p>

    {{-- IMPORT LOWONGAN --}}
    <form action="/jobs/import" method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf
        <div class="d-flex gap-2">
            <input type="file" name="file" required class="form-control">
            <button type="submit" class="btn btn-info">Import</button>  
            <a href="{{ route('jobs.import.template') }}"
                class="btn btn-primary">
                Template
            </a>
        </div>
    </form>

    <div class="d-flex gap-2 mb-4">
        <select id="exportSelect" class="form-select">
            <option value="">Export Semua Pelamar</option>
            @foreach($jobs as $job)
                <option value="{{ route('applications.export', $job->id) }}">
                    Export: {{ $job->title }}
                </option>
            @endforeach
        </select>
        <a href="{{ route('applications.filter', $job->id) }}" class="btn btn-primary">Filter</a>
        <a href="{{ route('applications.export') }}" class="btn btn-warning">Export</a>
    </div>

    {{-- TABLE --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nama Pelamar</th>
                    <th>Lowongan</th>
                    <th>CV</th>
                    <th>Status</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    <tr>
                        <td>{{ $app->user->name }}</td>
                        <td>{{ $app->job->title }}</td>

                        <td>
                            <a href="{{ asset('storage/' . $app->cv) }}" 
                               target="_blank"
                               class="btn btn-sm btn-primary">
                                Lihat CV
                            </a>
                            <a href="{{ asset('storage/' . $app->cv) }}" 
                                class="btn btn-outline-warning btn-sm"
                                download>
                                🗳️
                            </a>
                        </td>

                        <td>
                            @php
                                $statusClass = [
                                    'Pending' => 'badge bg-warning text-dark',
                                    'Accepted' => 'badge bg-success',
                                    'Rejected' => 'badge bg-danger'
                                ];
                            @endphp
                            <span class="{{ $statusClass[$app->status] ?? 'badge bg-secondary' }}">
                                {{ $app->status }}
                            </span>
                        </td>

                        <td>
                            <div class="d-flex gap-2">

                                {{-- ACCEPT --}}
                                <form action="{{ route('applications.update', $app->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Accepted">
                                    <button class="btn btn-success btn-sm" type="submit">Terima</button>
                                </form>

                                {{-- REJECT --}}
                                <form action="{{ route('applications.update', $app->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Rejected">
                                    <button class="btn btn-danger btn-sm" type="submit">Tolak</button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            Belum ada pelamar yang mendaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

