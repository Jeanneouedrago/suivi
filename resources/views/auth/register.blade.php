<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <style>
        body {
            background: linear-gradient(to right, #c0f0d0, #a0cfff);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .register-box {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background: crimson;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
        }
        button[type="submit"]:hover {
            background: #b01030;
        }
        a {
            color: crimson;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .social-icons {
            margin-top: 20px;
        }
        .social-icons img {
            height: 32px;
            margin: 0 5px;
            vertical-align: middle;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>Register</h2>
        
        @if ($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="text" name="name" placeholder="Name" required autofocus>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
            
            <button type="submit">Register</button>
        </form>

        <div style="margin-top:20px;">
            Already have an account? <a href="{{ route('login') }}">Login</a>
        </div>
        
    </div>
</body>
</html>