<?php
session_start();
if (!isset($_SESSION['userType'])) {
    header("Location: cek_login.php");
    exit();
}

// Tampilkan tampilan dashboard mahasiswa
echo "Selamat datang, Mahasiswa! Ini adalah dashboard Anda.";
// Tambahkan elemen-elemen tampilan atau fungsi yang sesuai
?>
