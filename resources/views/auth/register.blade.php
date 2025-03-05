<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<div class="container mt-5">
    <h2>User Registration</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="f_name" class="form-label">First Name</label>
            <input type="text" name="f_name" class="form-control" placeholder="Enter A First Name" value="{{ old('f_name') }}">
            @error('f_name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="l_name" class="form-label">Last Name</label>
            <input type="text" name="l_name" class="form-control" placeholder="Enter A Last Name" value="{{ old('l_name') }}">
            @error('l_name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter A Email" value="{{ old('email') }}">
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" placeholder="Enter A Phone Number" value="{{ old('phone') }}">
            @error('phone')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select name="gender" class="form-control">
            <option value="">Select Gender</option>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male ♂️</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female ♀️</option>
                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('gender')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Profile Photo</label>
            <input type="file" name="photo" class="form-control">
            @error('photo')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" placeholder="Enter A Password" class="form-control">
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Conform Password</label>
            <input type="password" name="password_confirmation" placeholder="Enter A Conform Password" class="form-control">
            @error('password_confirmation')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
        <button type="reset" class="btn btn-primary">Cancel</button>
    </form>

    <p>If you have an account? <a href="{{ route('login') }}">Login Here</a></p>
</div>
</body>
</html>
