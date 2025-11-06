@extends('layouts.master')

@section('title', 'Login')

@section('content')
    <div class="container card">
        <h2>Login</h2>

        @if (session('success'))
            <div style="background-color:aquamarine;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="post">
            @csrf
            <label for="email">Email:</label>
            <input type="email" name="email">
            <br>
            <label for="password">Password:</label>
            <input type="password" name="password">
            <br><br>
            <button type="submit">Login</button>
        </form>
    </div>
@endsection