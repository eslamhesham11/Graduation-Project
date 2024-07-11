<!-- resources/views/auth/login.blade.php -->
<form method="POST" action="/login">
    @csrf
    <input type="text" name="username" required>
    <input type="password" name="password" required>
    <button type="submit">Login</button>
</form>