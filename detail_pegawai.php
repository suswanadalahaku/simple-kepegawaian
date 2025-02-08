<?php
session_start();
include 'config/koneksi.php';

// Cek apakah user login
if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'pegawai') {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

// Ambil data pegawai berdasarkan email user
$query = "SELECT p.*, j.nama_jabatan, j.gaji 
          FROM pegawai p 
          LEFT JOIN jabatan j ON p.id_jabatan = j.id_jabatan 
          WHERE p.email = (SELECT email FROM users WHERE id_user = ?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$pegawai = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pegawai</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full text-center">
        <div class="flex items-center justify-center">
            <div class="w-24 h-24 bg-gray-300 rounded-full flex items-center justify-center">
                <span class="text-4xl font-bold text-gray-600"><?php echo strtoupper(substr($pegawai['nama'], 0, 1)); ?></span>
            </div>
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mt-4"><?php echo $pegawai['nama']; ?></h2>
        <p class="text-gray-500 text-sm"><?php echo $pegawai['email']; ?></p>

        <div class="mt-6 text-left space-y-3">
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-600 font-medium">No HP:</span>
                <span class="text-gray-800"><?php echo $pegawai['no_hp']; ?></span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-600 font-medium">Alamat:</span>
                <span class="text-gray-800 text-right"><?php echo $pegawai['alamat']; ?></span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-600 font-medium">Jabatan:</span>
                <span class="text-gray-800"><?php echo $pegawai['nama_jabatan'] ?? 'Tidak Ada'; ?></span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600 font-medium">Gaji:</span>
                <span class="text-gray-800 font-semibold">Rp<?php echo number_format($pegawai['gaji'] ?? 0, 0, ',', '.'); ?></span>
            </div>
        </div>

        <a href="proses/logout.php" class="mt-6 inline-block bg-red-500 text-white px-5 py-2 rounded-lg shadow hover:bg-red-600 transition">
            Logout
        </a>

        <!-- Tombol Ubah Password -->
        <button onclick="document.getElementById('modalPassword').classList.remove('hidden')" 
                class="mt-4 inline-block bg-blue-500 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-600 transition">
            Ubah Password
        </button>
    </div>

    <!-- Modal Ubah Password -->
    <div id="modalPassword" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Ubah Password</h3>
            <form action="proses/proses_ubah_password.php" method="POST">
                <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">

                <label class="block text-gray-600 text-sm mb-1">Password Lama</label>
                <input type="password" name="password_lama" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 mb-3">

                <label class="block text-gray-600 text-sm mb-1">Password Baru</label>
                <input type="password" name="password_baru" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 mb-3">

                <label class="block text-gray-600 text-sm mb-1">Konfirmasi Password</label>
                <input type="password" name="konfirmasi_password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 mb-4">

                <div class="flex justify-between">
                    <button type="button" onclick="document.getElementById('modalPassword').classList.add('hidden')" 
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                        Batal
                    </button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
