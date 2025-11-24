@extends('layouts.master')

@section('title', 'Profile')

@section('content')
    <div class="container card">
        <h1>Profile</h1>

        <div>Nama: {{ $user_name }}</div>
        <div>Role: {{ $user_role }}</div>
        <div>Email: {{ $user_email }}</div>

        <br>
        <form action="{{ route('logout') }}" method="post">
            @csrf   
            <button type="submit" style="background-color: red">Logout</button>
        </form>
    </div>
@endsection