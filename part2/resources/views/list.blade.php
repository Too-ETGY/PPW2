@extends("layouts.master")

@section('title')
Welcome
@endsection

@section('content')
<div class="">
    <h1>Liat aja</h1>
    {{-- <ol class="list-group list-group-flush">
        @for ($i = 1; $i<=5; $i++)
            <li class="list-group-item bg-transparent">
                <a href="/see/{{$i}}">Link {{$i}}</a>
            </li>
        @endfor
    </ol> --}}
</div>
@endsection