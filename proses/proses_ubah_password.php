<?php
session_start();
include '../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_user = $_POST['id_user'];
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    // Cek apakah semua input sudah diisi
    if (empty($password_lama) || empty($password_baru) || empty($konfirmasi_password)) {
        echo "<script>alert('Semua kolom harus diisi!'); window.history.back();</script>";
        exit();
    }

    // Validasi konfirmasi password
    if ($password_baru !== $konfirmasi_password) {
        echo "<script>alert('Konfirmasi password tidak cocok!'); window.history.back();</script>";
        exit();
    }

    // Ambil password lama dari database
    $query = "SELECT password FROM users WHERE id_user = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    // Periksa apakah password lama cocok
    if ($user && password_verify($password_lama, $user['password'])) {
        // Hash password baru
        $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);

        // Update password di database
        $updateQuery = "UPDATE users SET password = ? WHERE id_user = ?";
        $updateStmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, "si", $password_hash, $id_user);
        mysqli_stmt_execute($updateStmt);

        echo "<script>alert('Password berhasil diperbarui!'); window.location.href='../detail_pegawai.php';</script>";
    } else {
        echo "<script>alert('Password lama salah!'); window.history.back();</script>";
    }

    // Tutup koneksi
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
