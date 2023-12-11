<?php
require_once('koneksi.php');
session_start();

if (!isset($_SESSION['userType']) || !isset($_SESSION['userEmail'])) {
    header("Location: cek_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $idMengumpulkanTugas = $_GET['id'];

    // Lakukan proses penghapusan data dari tabel submit_tugas
    $queryHapusTugas = "DELETE FROM submit_tugas WHERE id_mengumpulkan_tugas = ?";
    $stmtHapusTugas = $conn->prepare($queryHapusTugas);
    $stmtHapusTugas->bind_param('i', $idMengumpulkanTugas);

    if ($stmtHapusTugas->execute()) {
        echo "Tugas berhasil dihapus.";
    } else {
        echo "Error: " . $stmtHapusTugas->error;
    }

    $stmtHapusTugas->close();
} else {
    echo "ID Tugas tidak valid.";
}

header("Location: mahasiswa.php"); // Ganti halaman_sebelumnya.php dengan halaman yang sesuai
exit();
?>
