<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    @if(Auth::check())
        <h1>Welcome, {{ Auth::user()->f_name }}!</h1>
        <p>Email: {{ Auth::user()->email }}</p>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>

    @else
        <script>window.location.href = "{{ route('login') }}";</script>
    @endif
</body>
</html> -->
