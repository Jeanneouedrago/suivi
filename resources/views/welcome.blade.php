<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bienvenue sur TransitFlow</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #fdfdfc;
            color: #1b1b18;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            width: 100%;
            padding: 15px 30px;
            display: flex;
            justify-content: flex-end;
            background: white;
            border-bottom: 1px solid #ddd;
        }
        header a {
            margin-left: 15px;
            text-decoration: none;
            color: #1b1b18;
            font-weight: 600;
        }
        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 40px 20px;
        }
        h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        h2 {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }
        
        .welcome-img {
            margin-top: 30px;
            max-width: 500px;
            width: 90%;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header>
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        @endif
    </header>

    <!-- MAIN CONTENT -->
    <main>
        <h1>BIENVENUE SUR TRANSITFLOW</h1>
        <h2>Suivi de colis</h2>

        <!-- IMAGE -->
        <img src="{{ asset('storage/image/Colis.jpeg') }}" alt="image" class="welcome-img">
    </main>
</body>
</html>
