<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae soluta sequi, tempore veritatis hic repellendus obcaecati unde quasi maiores, quam numquam reprehenderit saepe itaque rerum fuga ea ullam, fugiat tempora.</p>


    {{-- <div>Nama: {{ Auth::user()->name }}</div>
    <div>Role: {{ Auth::user()->role }}</div> --}}

    <br>
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit" style="background-color: red">Logout</button>
    </form>
</body>
</html>