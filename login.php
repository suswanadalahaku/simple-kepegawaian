<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <form action="proses/proses_login.php" method="POST" class="bg-white p-6 rounded shadow-md w-80">
        <h2 class="text-xl font-bold mb-4 text-center">Login</h2>
        
        <label class="block mb-2">Username atau Email:</label>
        <input type="text" name="username_email" placeholder="Masukkan Username atau Email" required class="border p-2 w-full rounded mb-3">
        
        <label class="block mb-2">Password:</label>
        <input type="password" name="password" placeholder="Masukkan Password" required class="border p-2 w-full rounded mb-3">
        
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded w-full">Login</button>
    </form>
</body>
</html>
