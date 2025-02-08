<?php
include 'config/koneksi.php';
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM pegawai WHERE id_pegawai = $id");
$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pegawai</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-xl font-bold text-gray-700 mb-4 text-center">Edit Data Pegawai</h2>

        <?php if (isset($_GET['msg'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 rounded">
                <?php echo htmlspecialchars($_GET['msg']); ?>
            </div>
        <?php endif; ?>

        <form action="proses/proses_edit.php" method="POST">
            <input type="hidden" name="id_pegawai" value="<?php echo $data['id_pegawai']; ?>">

            <label class="block text-sm font-medium text-gray-600">Nama</label>
            <input type="text" name="nama" value="<?php echo $data['nama']; ?>" required class="border p-2 w-full rounded mb-2">

            <label class="block text-sm font-medium text-gray-600">Email</label>
            <input type="email" name="email" value="<?php echo $data['email']; ?>" required class="border p-2 w-full rounded mb-2">

            <label class="block text-sm font-medium text-gray-600">No. HP</label>
            <input type="text" name="no_hp" value="<?php echo $data['no_hp']; ?>" required class="border p-2 w-full rounded mb-2">

            <label class="block text-sm font-medium text-gray-600">Alamat</label>
            <textarea rows="3" name="alamat" required class="border p-2 w-full rounded mb-2 resize-y"><?php echo $data['alamat']; ?></textarea>

            <label class="block text-sm font-medium text-gray-600">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="<?php echo $data['tanggal_lahir']; ?>" required class="border p-2 w-full rounded mb-2">

            <label class="block text-sm font-medium text-gray-600">Jabatan</label>
            <select name="id_jabatan" required class="border p-2 w-full rounded mb-2">
                <?php
                $jabatan_query = mysqli_query($conn, "SELECT * FROM jabatan");
                while ($jabatan = mysqli_fetch_assoc($jabatan_query)) {
                    $selected = ($jabatan['id_jabatan'] == $data['id_jabatan']) ? "selected" : "";
                    echo "<option value='{$jabatan['id_jabatan']}' $selected>{$jabatan['nama_jabatan']}</option>";
                }
                ?>
            </select>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded w-full mt-4 hover:bg-blue-600 transition">
                Simpan Perubahan
            </button>

            <a href="dashboard.php" class="block text-sm text-center text-blue-500 mt-4 hover:underline">Kembali ke Dashboard</a>
        </form>
    </div>
</body>
</html>
