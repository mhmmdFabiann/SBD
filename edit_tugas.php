<?php
// Tambahkan kode ini di awal file edit_materi.php
session_start();
if (!isset($_SESSION['userType']) && !isset($_SESSION['userEmail'])) {
    header("Location: cek_login.php");
    exit();
}

require_once('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['kode_tugas'])) {
    $kode_tugas = $_GET['kode_tugas'];
    $sql = "SELECT * FROM tugas WHERE kode_tugas = '$kode_tugas'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama_tugas = $row['nama_tugas'];
        $kode_tugas =$row['kode_tugas'];
        $lampiran_tugas = $row['lampiran_tugas'];
        $deadline = $row['deadline'];
        $kode_mk = $row['kode_mk'];
    } else {
        echo "Tugas not found";
        exit();
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kode_tugas'])) {
    $kode_mk = $_POST['kode_mk'];
    $kode_tugas = $_POST['kode_tugas'];
    $nama_tugas = $_POST['nama_tugas'];
    $lampiran_tugas = $_POST['lampiran_tugas'];
    $dl_tugas = $_POST['deadline'];
    

    $sql = "UPDATE tugas
            SET kode_mk='$kode_mk',kode_tugas='$kode_tugas' ,nama_tugas='$nama_tugas', lampiran_tugas='$lampiran_tugas', deadline='$dl_tugas'
            WHERE kode_tugas='$kode_tugas'";

    if ($conn->query($sql) === TRUE) {
        header("Location:matkul.php?kode_mk=$kode_mk");exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
}
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
            <div class="card-body">
                <!-- Form untuk menambah tugas -->
                <form action="edit_tugas.php" method="post">
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

                    <button type="submit" class="btn btn-primary">Selesai</button>
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

