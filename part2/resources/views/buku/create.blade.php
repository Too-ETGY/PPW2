@extends("layouts.master")

@section('title')
Buku
@endsection

@section('content')
<div class="text-white text-center">
    <h1 class="">Tambah Buku</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{route('buku.store')}}" class="text-start mt-3 bg-success p-3 bg-opacity-25">
        @csrf
        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" class="form-control" name="judul">
        </div>
        <div class="mb-3">
            <label class="form-label">Nama penulis</label>
            <input type="text" class="form-control" name="penulis">
        </div>
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" class="form-control" name="harga">
        </div>
        <div class="mb-5">
            <label class="form-label">Tanggal terbit</label>
            <input type="date" class="form-control" name="tgl_terbit">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{route('buku')}}" class="btn btn-secondary">Kembali</a>
    </form>

</div>
@endsection