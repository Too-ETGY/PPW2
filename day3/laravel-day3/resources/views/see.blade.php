@extends("layouts.master")

@section('title')
See {{$id}}
@endsection

@section('content')
<div class="">
    <h1>Nomor {{$id}}</h1>
    <center>
        <img id="item{{$id}}" alt="Random image">
    </center>
</div>

<script>
    window.currentId = @json($id);
</script>
<script src="{{ asset('js/script.js') }}"></script>
@endsection
