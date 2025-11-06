<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    </head>
    <body class="site-body">
        <header class="site-header">
            @if (Route::has('login'))
                <nav class="navbar navbar-expand-lg bg-body-tertiary">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="/">GotJob</a>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                @auth
                                    <li class="nav-item">
                                        <a href="{{ url('/dashboard') }}" class="btn btn-outline {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/profile') }}" class="btn btn-outline {{ request()->routeIs('profile') ? 'active' : '' }}">Profile</a>
                                    </li>
                                    {{-- @if (Auth::user()->IsAdmin) --}}
                                        <li class="nav-item">
                                            <a href="{{ url('admin/jobs') }}" class="btn btn-outline {{ request()->routeIs('jobs.index') ? 'active' : '' }}">Jobs</a>
                                        </li>
                                    {{-- @endif --}}
                                @else
                                    <li class="nav-item">
                                        <a href="{{ route('login') }}" class="btn {{ request()->routeIs('login') ? 'active' : '' }}">Log in</a>
                                    </li>

                                    @if (Route::has('register'))
                                    <li>
                                        <a href="{{ route('register') }}" class="btn btn-outline {{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
                                    </li>
                                    @endif
                                @endauth    
                            </ul>
                        </div>
                    </div>
                </nav>
            @endif
        </header>

        {{-- content slot --}}
        <main class="site-main container mt-3">
            @yield('content')
        </main>

        @if (Route::has('login'))
            <div class="spacer" aria-hidden="true"></div>
        @endif

    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>
