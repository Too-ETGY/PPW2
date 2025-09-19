@extends("layouts.master")

@section('title')
Buku
@endsection

@section('content')
<div class="text-white text-center">
    <h1 class="mb-5">Daftar Buku</h1>

    <div class="d-flex gap-3 justify-content-between">
        <div class="card mb-3" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Total Buku</h5>
                <p class="card-text">{{$total_books}}</p>
            </div>
        </div>
        <div class="card mb-3" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Total Harga</h5>
                <p class="card-text">{{"Rp.".number_format((float)$total_price, 2, ',', '.')}}</p>
            </div>
        </div>
        <div class="card mb-3" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Harga minimal</h5>
                <p class="card-text">{{"Rp.".number_format((float)$min_price, 2, ',', '.')}}</p>
            </div>
        </div>
        <div class="card mb-3" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Haga maksimal</h5>
                <p class="card-text">{{"Rp.".number_format((float)$max_price, 2, ',', '.')}}</p>
            </div>
        </div>
    </div>
    
    <h3 class="text-start mt-2">5 Judul paling baru</h3>
    <div class="d-flex align-item-start ">
        @foreach ($five_newest as $index=>$buku)
        <div class="card mx-3" style="width: 18rem;">
            <div class="card-title">
                <img src="https://picsum.photos/id/{{$index+11}}/600/400" class="card-img-top" alt="...">
                <h5>{{$buku->judul}}</h5>
            </div>
            <div class="card-body">
                <p class="card-text">    
                    <b>{{$buku->penulis}}</b>
                    <div>{{$buku->tgl_terbit->format('d/m/Y')}}</div>
                </p>
            </div>
        </div>
        @endforeach
    </div>

    <form method="GET" class="mb-3 mt-5 d-flex gap-2">
        <input type="text" name="judul" class="form-control"
            placeholder="Cari judul buku" value="{{ $search }}">

        <select class="form-select" aria-label="Default select example" name="penulis">
            <option disabled {{ empty($nama_penulis) ? 'selected' : '' }}>Cari Penulis</option>
            @foreach ($data_buku as $penulis)
                <option value="{{ $penulis->penulis }}" 
                    {{ $nama_penulis == $penulis->penulis ? 'selected' : '' }}>
                    {{ $penulis->penulis }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary">🔍</button>
        @if (!empty($search) || !empty($nama_penulis))
            <a href="{{ url('/buku') }}" class="btn btn-secondary">X</a>
        @endif
    </form>
    
    <table class="table table-striped table-light">
        <thead>
            <tr>
                <th>id</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Harga</th>
                <th>Tanggal Terbit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_buku as $buku)
            <tr>
                <td>{{ $buku->id }}</td>
                <td>{{ $buku->judul }}</td>
                <td>{{ $buku->penulis }}</td>
                <td>{{ "Rp.".number_format((float)$buku->harga, 2, ',', '.') }}</td>
                <td>{{ $buku->tgl_terbit->format('d/m/Y') }}</td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection