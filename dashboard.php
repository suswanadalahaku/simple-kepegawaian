<?php
session_start();
include 'config/koneksi.php';

// Ambil data pegawai beserta jabatan dan gaji
$query = "
    SELECT pegawai.id_pegawai, pegawai.nama, pegawai.email, pegawai.tanggal_lahir, 
           jabatan.nama_jabatan, jabatan.gaji 
    FROM pegawai 
    LEFT JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan
";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center p-6">

    <div class="w-full max-w-4xl bg-white p-6 rounded-lg shadow-md">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Dashboard Pegawai</h2>
            <button onclick="document.getElementById('logoutModal').classList.remove('hidden')" 
                class="bg-red-500 text-white px-4 py-2 rounded shadow hover:bg-red-600 transition">
                Logout
            </button>
        </div>

        <!-- Tombol Tambah Pegawai -->
        <a href="tambah_pegawai.php" 
            class="block text-center bg-green-500 text-white px-4 py-2 rounded shadow hover:bg-green-600 transition mb-4">
            Tambah Pegawai
        </a>

        <!-- Tabel Pegawai -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 shadow-md rounded-lg bg-white">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="border p-3">ID</th>
                        <th class="border p-3">Nama</th>
                        <th class="border p-3">Email</th>
                        <th class="border p-3">Tanggal Lahir</th>
                        <th class="border p-3">Jabatan</th>
                        <th class="border p-3">Gaji</th>
                        <th class="border p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="hover:bg-gray-100 transition">
                            <td class="border p-3 text-center"><?php echo $row['id_pegawai']; ?></td>
                            <td class="border p-3"><?php echo $row['nama']; ?></td>
                            <td class="border p-3"><?php echo $row['email']; ?></td>
                            <td class="border p-3 text-center"><?php echo $row['tanggal_lahir']; ?></td>
                            <td class="border p-3 text-center"><?php echo $row['nama_jabatan'] ?? 'Tidak Ada'; ?></td>
                            <td class="border p-3 text-center">Rp<?php echo number_format($row['gaji'] ?? 0, 0, ',', '.'); ?></td>
                            <td class="border p-3 text-center">
                                <a href="edit_pegawai.php?id=<?php echo $row['id_pegawai']; ?>" 
                                    class="m-1 px-3 py-1 bg-yellow-500 text-white rounded shadow hover:bg-yellow-600 transition">
                                    Edit
                                </a>
                                <button onclick="confirmDelete(<?php echo $row['id_pegawai']; ?>)" 
                                    class="m-1 px-3 py-1 bg-red-500 text-white rounded shadow hover:bg-red-600 transition">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Konfirmasi Logout -->
    <div id="logoutModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded shadow-lg text-center">
            <h2 class="text-xl font-bold mb-4">Konfirmasi Logout</h2>
            <p>Apakah Anda yakin ingin logout?</p>
            <div class="mt-4 flex justify-center gap-4">
                <a href="proses/logout.php" 
                    class="bg-red-500 text-white px-4 py-2 rounded shadow hover:bg-red-600 transition">
                    Logout
                </a>
                <button onclick="document.getElementById('logoutModal').classList.add('hidden')" 
                    class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 transition">
                    Batal
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded shadow-lg text-center">
            <h2 class="text-lg font-bold mb-4">Konfirmasi Hapus</h2>
            <p>Apakah Anda yakin ingin menghapus data pegawai ini?</p>
            <div class="mt-4 flex justify-center gap-4">
                <a id="deleteConfirm" href="#" class="bg-red-500 text-white px-4 py-2 rounded">Hapus</a>
                <button onclick="document.getElementById('deleteModal').classList.add('hidden')" class="bg-gray-500 text-white px-4 py-2 rounded">
                    Batal
                </button>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            document.getElementById('deleteConfirm').href = "proses/proses_delete.php?id=" + id;
            document.getElementById('deleteModal').classList.remove('hidden');
        }
    </script>

</body>
</html>
