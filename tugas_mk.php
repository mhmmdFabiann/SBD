<?php
session_start();
if (!isset($_SESSION['userType']) && !isset($_SESSION['userEmail'])) {
    header("Location: cek_login.php");
    exit();
}

// Ambil parameter kode_mk dari URL
$kodeMk = $_GET['kode_mk'];

// Ambil data mata kuliah dari database
require_once('koneksi.php'); // Sesuaikan dengan file koneksi Anda
$queryMkDetail = "SELECT * FROM mata_kuliah WHERE kode_mk = ?";
$stmtMkDetail = $conn->prepare($queryMkDetail);
$stmtMkDetail->bind_param('s', $kodeMk);
$stmtMkDetail->execute();
$resultMkDetail = $stmtMkDetail->get_result();
$mkDetail = $resultMkDetail->fetch_assoc();
$stmtMkDetail->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tugas</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .custom-card {
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1); /* Add shadow */
            background-color: #f8f9fa; /* Add background color */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card custom-card">
            <div class="card-header">
                <h3 class="mb-0">Tambah Tugas untuk Mata Kuliah <?= $mkDetail['nama_mk'] ?></h3>
            </div>
            <div class="card-body">
                <!-- Form untuk menambah tugas -->
                <form action="proses_tambah_tugas.php" method="post">
                    <input type="hidden" name="kode_mk" value="<?= $kodeMk ?>">

                    <div class="form-group">
                        <label for="kode_tugas">Kode Tugas:</label>
                        <input type="text" class="form-control" id="kode_tugas" name="kode_tugas" required>
                    </div>

                    <div class="form-group">
                        <label for="nama_tugas">Judul Tugas:</label>
                        <input type="text" class="form-control" id="nama_tugas" name="nama_tugas" required>
                    </div>

                    <div class="form-group">
                        <label for="lampiran_tugas">Deskripsi / Lampiran Tugas:</label>
                        <textarea class="form-control" id="lampiran_tugas" name="lampiran_tugas" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="deadline">Deadline:</label>
                        <input type="datetime-local" class="form-control" id="deadline" name="deadline" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Tambah Tugas</button>
                </form>
            </div>
            <!-- Tombol kembali ke detail mata kuliah -->
            <div class="card-footer">
                <a href="matkul.php?kode_mk=<?= $kodeMk ?>" class="btn btn-secondary">Kembali ke Detail Mata Kuliah</a>
            </div>
        </div>
    </div>
</body>
</html>



