<!-- resources/views/user/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>

<body>
    <h1>Selamat datang di user Dashboard</h1>
    <p>Ini adalah halaman khusus untuk user.</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-red-500">Logout</button>
</body>

</html>
