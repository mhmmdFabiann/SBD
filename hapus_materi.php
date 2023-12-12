<?php
session_start();
if (!isset($_SESSION['userType']) && !isset($_SESSION['userEmail'])) {
    header("Location: cek_login.php");
    exit();
}

require_once('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['kode_materi']) && isset($_GET['kode_mk'])) {
    $kode_materi = $_GET['kode_materi'];
    $kode_mk = $_GET['kode_mk'];

    $sql = "DELETE FROM materi_pembelajaran WHERE kode_materi = '$kode_materi'";

    if ($conn->query($sql) === TRUE) {
        header("Location: matkul.php?kode_mk=$kode_mk");
exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $conn->close();
}
?>