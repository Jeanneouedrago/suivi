<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body {
            background: linear-gradient(to right, #c0f0d0, #a0cfff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .login-box {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        input {
            width: 100%;
            margin-bottom: 15px;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 12px;
            background: crimson;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background: #b01030;
        }
        a {
            color: crimson;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Sign In</h2>
        
        @if ($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" placeholder="email" required autofocus>
            <input type="password" name="password" placeholder="Password" required>
            
            <button type="submit" class="btn-crimson">Login</button>
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top:15px;">
                <label style="display: flex; align-items: center; margin: 0;">
                    <input type="checkbox" name="remember" style="width: auto; margin-right:5px;"> Remember me
                </label>
                <a href="{{ route('password.request') }}">Forgot password?</a>
            </div>
        </form>
        
        <div style="margin-top:20px;">
            Don't have an account? <a href="{{ route('register') }}">Register here</a>
        </div>
    </div>
</body>
</html>