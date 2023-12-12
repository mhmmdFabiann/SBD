<?php
session_start();
if (!isset($_SESSION['userType']) && !isset($_SESSION['userEmail'])) {
    header("Location: cek_login.php");
    exit();
}

// Ambil data dosen dari database
require_once('koneksi.php'); // Sesuaikan dengan file koneksi Anda
$dsnEmail = $_SESSION['userEmail'];
$query = "SELECT * FROM dosen WHERE email_dsn = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $dsnEmail);
$stmt->execute();
$resultDosen = $stmt->get_result();
$dosenData = $resultDosen->fetch_assoc();
$stmt->close();

// Ambil mata kuliah yang diampu oleh dosen
$queryMk = "SELECT * FROM mata_kuliah WHERE id_dosen = ?";
$stmtMk = $conn->prepare($queryMk);
$stmtMk->bind_param('s', $dosenData['id_dosen']);
$stmtMk->execute();
$resultMk = $stmtMk->get_result();
$mkData = $resultMk->fetch_all(MYSQLI_ASSOC);
$stmtMk->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dosen Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #ffffff;
            border-radius: 5px 5px 0 0;
        }

        .card-body:hover {
            background-color: #f0f0f0;
            cursor: pointer;
        }

        h3, h4 {
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h3 class="mb-4">Selamat Datang, <?= $dosenData['nama_dosen'] ?>!</h3>

        <!-- Tampilkan data dosen -->
        <div class="card mb-4">
            <div class="card-header">
                Profil
            </div>
            <div class="card-body">
                <p><strong>ID :</strong> <?= $dosenData['id_dosen'] ?></p>
                <p><strong>Email :</strong> <?= $dosenData['email_dsn'] ?></p>
                <p><strong>Bidang Keahlian :</strong> <?= $dosenData['bidang_keahlian'] ?></p>
            </div>
        </div>

        <!-- Tulisan "Mata Kuliah yang Diampu" di atas kotak mata kuliah -->
        <h4>Mata Kuliah yang Diampu</h4>

        <!-- Tampilkan mata kuliah yang diampu -->
        <?php foreach ($mkData as $mk): ?>
            <div class="card mt-4">
                <div class="card-body" onclick="window.location.href='matkul.php?kode_mk=<?= $mk['kode_mk'] ?>'">
                    <!-- Setiap mata kuliah memiliki card/container yang berbeda -->
                    <strong><?= $mk['nama_mk'] ?></strong> - <?= $mk['kode_mk'] ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>