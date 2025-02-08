<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pegawai</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold text-center mb-4 text-gray-700">Tambah Pegawai</h2>
        
        <form action="proses/proses_tambah.php" method="POST">
            <div class="mb-3">
                <label class="block text-gray-700 font-medium">Nama</label>
                <input type="text" name="nama" required class="border p-2 w-full rounded focus:ring focus:ring-blue-300">
            </div>

            <div class="mb-3">
                <label class="block text-gray-700 font-medium">Email</label>
                <input type="email" name="email" required class="border p-2 w-full rounded focus:ring focus:ring-blue-300">
            </div>

            <div class="mb-3">
                <label class="block text-gray-700 font-medium">No HP</label>
                <input type="text" name="no_hp" required class="border p-2 w-full rounded focus:ring focus:ring-blue-300">
            </div>

            <div class="mb-3">
                <label class="block text-gray-700 font-medium">Alamat</label>
                <textarea name="alamat" required class="border p-2 w-full rounded focus:ring focus:ring-blue-300"></textarea>
            </div>

            <div class="mb-3">
                <label class="block text-gray-700 font-medium">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" required class="border p-2 w-full rounded focus:ring focus:ring-blue-300">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Jabatan</label>
                <select name="id_jabatan" required class="border p-2 w-full rounded focus:ring focus:ring-blue-300">
                    <option value="" disabled selected>Pilih Jabatan</option>
                    <?php
                    include 'config/koneksi.php';
                    $query = "SELECT id_jabatan, nama_jabatan FROM jabatan";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='".$row['id_jabatan']."'>".$row['nama_jabatan']."</option>";
                    }
                    mysqli_close($conn);
                    ?>
                </select>
            </div>

            <div class="mb-3">
            <label class="block text-gray-700 font-medium">Password:</label>
            <input type="password" name="password" type="text" required class="border p-2 w-full rounded focus:ring focus:ring-blue-300">
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded w-full hover:bg-green-600 transition">
                Tambah Pegawai
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-4">
            <a href="dashboard.php" class="text-blue-500 hover:underline">Kembali ke Dashboard</a>
        </p>
    </div>
</body>
</html>
