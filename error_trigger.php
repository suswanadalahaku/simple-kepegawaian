<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error!</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-red-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-md w-96 text-center">
        <h2 class="text-2xl font-bold text-red-600 mb-4">Terjadi Kesalahan!</h2>
        
        <p class="text-gray-700 mb-4">
            <?php 
            echo isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : "Terjadi kesalahan yang tidak diketahui.";
            ?>
        </p>

        <a href="javascript:history.back()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
            Kembali
        </a>

    </div>
</body>
</html>
