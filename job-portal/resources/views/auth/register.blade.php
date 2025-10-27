@extends('layouts.master')

@section('title', 'Register')

@section('content')
    <div class="max-w-[335px] lg:max-w-4xl p-6 bg-white rounded-lg">
        <h2>Register</h2>
        <form action="{{ route('register.post') }}" method="post">
            @csrf
            <p>Nama:</p>
            <input type="text" name="name">
            <br>

            <p>Email:</p>
            <input type="email" name="email">
            <br>
            
            <p>Password:</p>
            <input type="password" name="password">
            <br>
            
            <p>Konfirmasi Password:</p>
            <input type="password" name="password_confirmation">
            <br>
            
            <p>Register as:</p>
            <input type="radio" name="role" value="HR">
            <label>HR</label><br>
            <input type="radio" name="role" value="Job Seeker">
            <label>Job Seeker</label><br>

            <br>
            <button type="submit">Register</button>
        </form>
    </div>
@endsection