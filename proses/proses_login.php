<?php
session_start();
include '../config/koneksi.php';

$username_email = $_POST['username_email'];
$password = $_POST['password'];

// Cek apakah input adalah email atau username
$query = "SELECT * FROM users WHERE username = ? OR email = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ss", $username_email, $username_email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($user = mysqli_fetch_assoc($result)) {
    // Verifikasi password
    if (password_verify($password, $user['password'])) {
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: ../dashboard.php");
            exit();
        } elseif ($user['role'] == 'pegawai') {
            // Cari id_pegawai berdasarkan email di tabel pegawai
            $query_pegawai = "SELECT id_pegawai FROM pegawai WHERE email = ?";
            $stmt_pegawai = mysqli_prepare($conn, $query_pegawai);
            mysqli_stmt_bind_param($stmt_pegawai, "s", $user['email']);
            mysqli_stmt_execute($stmt_pegawai);
            $result_pegawai = mysqli_stmt_get_result($stmt_pegawai);

            if ($pegawai = mysqli_fetch_assoc($result_pegawai)) {
                $id_pegawai = $pegawai['id_pegawai'];
                header("Location: ../detail_pegawai.php?id=" . $id_pegawai);
                exit();
            } else {
                echo "<script>alert('Pegawai tidak ditemukan!'); window.location.href='../login.php';</script>";
            }
            mysqli_stmt_close($stmt_pegawai);
        }
    } else {
        echo "<script>alert('Login gagal! Periksa email dan password.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Username atau email tidak ditemukan!'); window.location.href='../login.php';</script>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
