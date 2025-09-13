@extends("layouts.master")

@section('title')
Welcome
@endsection

@section('content')
<div class="">
    <h1 style="color: rgb(95, 160, 127)">List gak tau apa</h1>
    <a href="list" style="text-decoration: underline; font-size: smaller;">ke list yang asli</a>
    <ol class="list-group list-group-flush">
        @for ($i = 1; $i<=5; $i++)
            <li class="list-group-item bg-transparent">
                <a href="/see/{{$i}}">Link {{$i}}</a>
            </li>
        @endfor
    </ol>
</div>
@endsection