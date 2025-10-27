@extends('layouts.master')

@section('title', 'Admin')

@section('content')
    <div class="max-w-[335px] lg:max-w-4xl p-6 bg-white rounded-lg">
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