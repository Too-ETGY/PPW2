@extends('layouts.master')

@section('title', 'Admin')

@section('content')
    <div class="container card">
        <h1>Admin Profile</h1>

        <div>Nama: {{ $user_name ?? auth()->user()->name ?? 'Admin' }}</div>
        <div>Role: {{ $user_role ?? 'Admin' }}</div>

        <br>
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" style="background-color: red">Logout</button>
        </form>
    </div>
@endsection