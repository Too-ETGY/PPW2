@extends('layouts.master')

@section('title', config('app.name', 'Laravel'))
@section('content')
    <div class="max-w-[335px] lg:max-w-4xl p-6 bg-white rounded-lg">
        <h1>Welcome to {{ config('app.name', 'Laravel') }}</h1>
        <p>Your gateway to exciting job opportunities!</p>
    </div>

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif
    </body>
</html>
