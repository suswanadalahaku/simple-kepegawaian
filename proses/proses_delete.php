<?php
include '../config/koneksi.php';

$id = $_GET['id'];

// Ambil email pegawai sebelum dihapus
$query_email = "SELECT email FROM pegawai WHERE id_pegawai = ?";
$stmt_email = mysqli_prepare($conn, $query_email);
mysqli_stmt_bind_param($stmt_email, "i", $id);
mysqli_stmt_execute($stmt_email);
$result_email = mysqli_stmt_get_result($stmt_email);

if ($row = mysqli_fetch_assoc($result_email)) {
    $email = $row['email'];

    // Hapus dari tabel users berdasarkan email
    $query_delete_users = "DELETE FROM users WHERE email = ?";
    $stmt_delete_users = mysqli_prepare($conn, $query_delete_users);
    mysqli_stmt_bind_param($stmt_delete_users, "s", $email);
    mysqli_stmt_execute($stmt_delete_users);
    mysqli_stmt_close($stmt_delete_users);
}

// Hapus dari tabel pegawai
$query_delete_pegawai = "DELETE FROM pegawai WHERE id_pegawai = ?";
$stmt_delete_pegawai = mysqli_prepare($conn, $query_delete_pegawai);
mysqli_stmt_bind_param($stmt_delete_pegawai, "i", $id);
mysqli_stmt_execute($stmt_delete_pegawai);
mysqli_stmt_close($stmt_delete_pegawai);

// Tutup koneksi dan redirect
mysqli_stmt_close($stmt_email);
mysqli_close($conn);
header("Location: ../dashboard.php");
exit();
?>
