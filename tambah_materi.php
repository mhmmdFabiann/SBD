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
    <title>Tambah Materi Pembelajaran</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Set background color */
        }

        .container {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff; 
            border-radius: 10px; 
            padding: 20px; 
            margin-top: 50px; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white"> <!-- Add background color to header -->
                <h3 class="mb-0">Tambah Materi Pembelajaran untuk Mata Kuliah <?= $mkDetail['nama_mk'] ?></h3>
            </div>
            <div class="card-body">
                <!-- Form untuk menambah materi pembelajaran -->
                <form action="proses_tambah_materi.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="kode_mk" value="<?= $kodeMk ?>">

                    <div class="form-group">
                        <label for="nama_materi">Nama Materi:</label>
                        <input type="text" class="form-control" id="nama_materi" name="nama_materi" required>
                    </div>

                    <div class="form-group">
                        <label for="kode_materi">Kode Materi:</label>
                        <input type="text" class="form-control" id="kode_materi" name="kode_materi" required>
                    </div>

                    <div class="form-group">
                        <label for="lampiran_materi">Lampiran :</label>
                        <input type="text" class="form-control" id="lampiran_materi" name="lampiran_materi" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Tambah Materi Pembelajaran</button>
                </form>
            </div>
            <div class="card-footer bg-light"> <!-- Add background color to footer -->
                <!-- Centered buttons -->
                <div>
                    <a href="matkul.php?kode_mk=<?= $kodeMk ?>" class="btn btn-danger">Batal</a>
                </div>
        </div>
    </div>
</body>
</html>




