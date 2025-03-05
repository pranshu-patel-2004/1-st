<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
</head>
<body>
    <div class="login-container">
        <h2>Customer Login</h2>
        @if(session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif
        <form action="{{ route('customer.login.submit') }}" method="POST">
            @csrf
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
