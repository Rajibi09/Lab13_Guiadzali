<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    @if (session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <p style="color:red;">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="/login">
        @csrf
        <label for="name">Name:</label>
        <input type="email" name="email" placeholder="Enter email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Password" required><br>
        
        <button type="submit">Login</button>
    </form>
        <p>Don't have an account? <a href="/register">Register</a></p>
</body>
</html>
