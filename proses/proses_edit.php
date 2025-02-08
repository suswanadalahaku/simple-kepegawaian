<?php
include '../config/koneksi.php';

// Tangkap data dari form
$id = $_POST['id_pegawai'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$no_hp = $_POST['no_hp'];
$alamat = $_POST['alamat'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$id_jabatan = $_POST['id_jabatan'];

// Pastikan data tidak kosong
if (empty($nama) || empty($email) || empty($no_hp) || empty($alamat) || empty($tanggal_lahir) || empty($id_jabatan)) {
    header("Location: ../error.php?msg=" . urlencode("Semua kolom harus diisi!"));
    exit;
}

try {
    // Gunakan prepared statement
    $query = "UPDATE pegawai SET nama = ?, email = ?, no_hp = ?, alamat = ?, tanggal_lahir = ?, id_jabatan = ? WHERE id_pegawai = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssssi", $nama, $email, $no_hp, $alamat, $tanggal_lahir, $id_jabatan, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../dashboard.php?msg=" . urlencode("Data berhasil diperbarui!"));
        exit;
    } else {
        throw new Exception("Gagal memperbarui data.");
    }
} catch (Exception $e) {
    header("Location: ../error_trigger.php?msg=" . urlencode($e->getMessage()));
    exit;
} finally {
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
