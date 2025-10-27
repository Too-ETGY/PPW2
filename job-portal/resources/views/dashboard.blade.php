@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-[335px] lg:max-w-4xl p-6 bg-white rounded-lg">
        <h1>Dashboard</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae soluta sequi, tempore veritatis hic repellendus obcaecati unde quasi maiores, quam numquam reprehenderit saepe itaque rerum fuga ea ullam, fugiat tempora.</p>

        <div>
            <a href="{{ route('profile') }}">Profile</a>
        </div>
    </div>
@endsection