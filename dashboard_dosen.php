<?php
session_start();
if (!isset($_SESSION['userType']) || !isset($_SESSION['userEmail'])) {
    header("Location: cek_login.php");
    exit();
}
// Tampilkan tampilan dashboard dosen
echo "Selamat datang, Dosen! Ini adalah dashboard Anda.";
// Tambahkan elemen-elemen tampilan atau fungsi yang sesuai
?>
