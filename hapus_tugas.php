<?php
session_start();
if (!isset($_SESSION['userType']) && !isset($_SESSION['userEmail'])) {
    header("Location: cek_login.php");
    exit();
}

require_once('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['kode_tugas']) && isset($_GET['kode_mk'])) {
    $kode_tugas = $_GET['kode_tugas'];
    $kode_mk = $_GET['kode_mk'];

    $sql = "DELETE FROM tugas WHERE kode_tugas = '$kode_tugas'";

    if ($conn->query($sql) === TRUE) {
        header("Location: matkul.php?kode_mk=$kode_mk");
exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $conn->close();
}
?>