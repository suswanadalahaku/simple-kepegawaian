<?php
include '../config/koneksi.php';

// Aktifkan mode error handling agar mysqli_throw_exception digunakan
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $id_jabatan = $_POST['id_jabatan'];
    $password_plain = $_POST['password'];

    // Hash password sebelum disimpan
    $password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);
    $role = 'pegawai';

    // Gunakan stored procedure untuk menambah pegawai
    $query = "CALL tambah_pegawai(?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssssi", $nama, $email, $no_hp, $alamat, $tanggal_lahir, $id_jabatan);

    if (mysqli_stmt_execute($stmt)) {
        // Ambil ID pegawai yang baru ditambahkan
        $id_pegawai = mysqli_insert_id($conn);

        // Tambahkan akun user setelah pegawai berhasil ditambahkan
        $query_user = "INSERT INTO users (username, email, password, role) 
                       VALUES (?, ?, ?, ?)";
        $stmt_user = mysqli_prepare($conn, $query_user);
        mysqli_stmt_bind_param($stmt_user, "ssss", $nama, $email, $password_hashed, $role);
        
        if (mysqli_stmt_execute($stmt_user)) {
            header("Location: ../dashboard.php");
            exit;
        } else {
            throw new Exception("Gagal menambahkan akun user.");
        }
    }
} catch (mysqli_sql_exception $e) {
    // Jika trigger di database menolak usia < 18, redirect ke error_trigger.php
    header("Location: ../error_trigger.php?msg=" . urlencode($e->getMessage()));
    exit;
} catch (Exception $e) {
    // Tangani error lain
    header("Location: ../error_trigger.php?msg=" . urlencode($e->getMessage()));
    exit;
} finally {
    // Tutup statement dan koneksi
    if (isset($stmt)) {
        mysqli_stmt_close($stmt);
    }
    if (isset($stmt_user)) {
        mysqli_stmt_close($stmt_user);
    }
    mysqli_close($conn);
}
?>
