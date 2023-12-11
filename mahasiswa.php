<?php
session_start();
if (!isset($_SESSION['userType']) && !isset($_SESSION['userEmail'])) {
    header("Location: cek_login.php");
    exit();
}

// Ambil data  dari database
require_once('koneksi.php'); // Sesuaikan dengan file koneksi Anda
$mhsEmail = $_SESSION['userEmail'];
$query = "SELECT * FROM mahasiswa WHERE email_mhs = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $mhsEmail);
$stmt->execute();
$resultMahasiswa = $stmt->get_result();
$mahasiswaData = $resultMahasiswa->fetch_assoc();
$stmt->close();

// Ambil mata kuliah yang diampu oleh dosen
$queryMk = "SELECT mk.* FROM mata_kuliah mk
                    JOIN pengambilan_mk mmk ON mk.kode_mk = mmk.kode_mk
                    WHERE mmk.id_mahasiswa = ?";
$stmtMk = $conn->prepare($queryMk);
$stmtMk->bind_param('s', $mahasiswaData['id_mahasiswa']);
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
            <h2 class="font-bold text-sm me-3"><?php echo $mahasiswaData['nama']; ?></h2>
        </div>
    </div>
    <div class="pt-10 flex justify-center flex-col">
        <h1 class="text-2xl font-bold text-center mb-10">Daftar Mata Kuliah</h1>
        <div class="flex justify-center flex-wrap items-stretch gap-4">
            <?php foreach ($mkData as $mk): ?>
                <div class="mb-3 flex justify-center flex-wrap matakuliah">
                    <div class="bg-white p-4 rounded-md shadow-lg w-[300px] flex flex-col">
                        <h5 class="text-xl font-bold mb-2"><?= $mk['nama_mk'] ?></h5>
                        <p class="text-gray-600 mb-5"> (<?= $mk['kode_mk'] ?>) </p>
                        <p class="text-gray-600 mb-5"> <?= $mk['sks'] ?> SKS</p>
                        <a href='mata-kuliah.php?kode_mk=<?= $mk['kode_mk'] ?>&nama_user=<?= urlencode($mahasiswaData['nama']) ?>' class='bg-blue-500 text-white py-2 px-4 mt-auto rounded-md content-end'>Lihat Detail</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>