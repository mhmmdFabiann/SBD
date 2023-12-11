<?php
session_start();
if (!isset($_SESSION['role']) && !isset($_SESSION['mail'])) {
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
    <title>Learning Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <style>
        .matakuliah:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-200 p-0 m-0 flex items-center justify-center flex-col">
    <div class="p-3 bg-gradient-to-r from-indigo-600 via-blue-600 to-yellow-300 text-slate-100 text-2xl flex w-full justify-between">
        <header class="text-center">
            <img src="unnes_header.png" alt="Header Image" class="w-full">
        </header>
        <h2 class="font-bold text-center ml-3">Learning Management System</h2>
        <div class="flex items-center text-end">
            <i class="bi bi-person me-2 mb-2"></i>
            <h2 class="font-bold text-sm me-3"><?php echo $namaDOSEN; ?></h2>
        </div>
    </div>
    <div class="pt-10 flex justify-center flex-col">
        <h1 class="text-2xl font-bold text-center mb-10">Daftar Mata Kuliah</h1>
        <div class="flex justify-center flex-wrap items-stretch gap-4">
            <?php
                while ($data = mysqli_fetch_array($resultMataKuliah)) {
                    echo "<div class='mb-3 flex justify-center flex-wrap matakuliah'>";
                    echo "<div class='bg-white p-4 rounded-md shadow-lg w-[300px] flex flex-col'>";
                    echo "<h5 class='text-xl font-bold mb-2'>".$data['nama_mk']."</h5>";
                    echo "<p class='text-gray-600 mb-5'>(".$data['kode_mk'].")</p>";
                    echo "<a href='menambahmateri.php?kode_mk=".$data['kode_mk']."&nama_user=".urlencode($namaDOSEN)."' class='bg-blue-500 text-white py-2 px-4 mt-auto rounded-md content-end'>Lihat Detail</a>";
                    echo "</div>";
                    echo "</div>";
                }
            ?>
        </div>
    </div>
</body>
</html>