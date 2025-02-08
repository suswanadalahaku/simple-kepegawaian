<?php
include 'config/koneksi.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM pegawai WHERE id_pegawai = $id");
header("Location: dashboard.php");
?>
