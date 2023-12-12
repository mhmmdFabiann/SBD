<?php
session_start();
if (!isset($_SESSION['userType']) && !isset($_SESSION['userEmail'])) {
    header("Location: cek_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $kodeMk = $_POST["kode_mk"];
    $namaMateri = $_POST["nama_materi"];
    $kodeMateri = $_POST["kode_materi"];
    $namaFile = $_POST['lampiran_materi'];
    // Lakukan operasi INSERT ke database untuk menyimpan informasi lampiran
    require_once('koneksi.php'); // Sesuaikan dengan file koneksi Anda

    $queryTambahLampiran = "INSERT INTO materi_pembelajaran (kode_mk, nama_materi, kode_materi, lampiran_materi) VALUES (?, ?, ?, ?)";
    $stmtTambahLampiran = $conn->prepare($queryTambahLampiran);
    $stmtTambahLampiran->bind_param("ssss", $kodeMk, $namaMateri, $kodeMateri, $namaFile);

    if ($stmtTambahLampiran->execute()) {
        header("Location: matkul.php?kode_mk=$kodeMk");
        exit();
    } else {
        echo "Gagal menyimpan informasi lampiran ke database.";
    }

    $stmtTambahLampiran->close();
    $conn->close();
} else {
    // Redirect jika bukan POST request
    header("Location: cek_login.php");
    exit();
}
?>
