<?php
session_start();
if (!isset($_SESSION['userType']) && !isset($_SESSION['userEmail'])) {
    header("Location: cek_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $kodeMk = $_POST["kode_mk"];
    $kodeTugas = $_POST["kode_tugas"];
    $namaTugas = $_POST["nama_tugas"];
    $deskripsi = $_POST["lampiran_tugas"];
    $deadline = $_POST["deadline"];

    // Validasi form disini sesuai kebutuhan
    
    // Proses tambah tugas ke database
    require_once('koneksi.php'); // Sesuaikan dengan file koneksi Anda

    $queryTambahTugas = "INSERT INTO tugas (kode_mk, kode_tugas, nama_tugas, lampiran_tugas, deadline) VALUES (?, ?, ?, ?, ?)";
    $stmtTambahTugas = $conn->prepare($queryTambahTugas);
    $stmtTambahTugas->bind_param("sssss", $kodeMk, $kodeTugas, $namaTugas, $deskripsi, $deadline);
    
    if ($stmtTambahTugas->execute()) {
        // Tugas berhasil ditambahkan
        header("Location: matkul.php?kode_mk=$kodeMk");
        exit();
    } else {
        // Gagal menambahkan tugas
        echo "Gagal menambahkan tugas.";
    }

    $stmtTambahTugas->close();
    $conn->close();
} else {
    // Redirect jika bukan POST request
    header("Location: cek_login.php");
    exit();
}
?>
