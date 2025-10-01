@extends("layouts.master")

@section('title')
Buku
@endsection

@section('content')
<div class="text-white text-center">
    <h1 class="">Edit Buku</h1>

    @if (session('success'))
        <div id="alert-success" class="alert alert-success">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(() => {
                const alert = document.getElementById('alert-success');
                if (alert) {
                    alert.style.display = 'none';
                }
            }, 3000);
        </script>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{route('buku.update', $get_buku->id)}}" class="text-start mt-3 bg-success p-3 bg-opacity-25">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" class="form-control bg-warning-subtle" name="judul" value="{{$get_buku->judul}}">
        </div>
        <div class="mb-3">
            <label class="form-label">Nama penulis</label>
            <input type="text" class="form-control bg-warning-subtle" name="penulis" value="{{$get_buku->penulis}}">
        </div>
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" class="form-control bg-warning-subtle" name="harga" value="{{$get_buku->harga}}">
        </div>
        <div class="mb-5">
            <label class="form-label">Tanggal terbit</label>
            <input type="date" class="form-control bg-warning-subtle" name="tgl_terbit" value="{{$get_buku->tgl_terbit->format('Y-m-d')}}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{route('buku')}}" class="btn btn-secondary">Kembali</a>
    </form>

</div>
@endsection