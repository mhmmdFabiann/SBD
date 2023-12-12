<?php
require_once('koneksi.php');
session_start();

if (!isset($_SESSION['userType']) || !isset($_SESSION['userEmail'])) {
    header("Location: cek_login.php");
    exit();
}

$mhsEmail = $_SESSION['userEmail'];

// Ambil id_mahasiswa dari tabel mahasiswa
$queryMahasiswa = "SELECT id_mahasiswa FROM mahasiswa WHERE email_mhs = ?";
$stmtMahasiswa = $conn->prepare($queryMahasiswa);
$stmtMahasiswa->bind_param('s', $mhsEmail);
$stmtMahasiswa->execute();
$resultMahasiswa = $stmtMahasiswa->get_result();
$mahasiswaData = $resultMahasiswa->fetch_assoc();
$stmtMahasiswa->close();
$idMahasiswa = $mahasiswaData['id_mahasiswa'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data dari form
    $kodeTugas = $_POST['kode_tugas'];
    $fileTugas = $_POST['file_tugas'];

    // Lakukan pengecekan data sebelum melakukan insert
    if (!empty($kodeTugas) && !empty($fileTugas)) {
        // Ambil data lain yang dibutuhkan dari tabel tugas dan mata_kuliah
        $queryTugas = "SELECT * FROM tugas WHERE kode_tugas = ?";
        $stmtTugas = $conn->prepare($queryTugas);
        $stmtTugas->bind_param('s', $kodeTugas);
        $stmtTugas->execute();
        $resultTugas = $stmtTugas->get_result();
        $tugasData = $resultTugas->fetch_assoc();
        $stmtTugas->close();

        $kodeMk = $tugasData['kode_mk'];

        $queryMkDetail = "SELECT * FROM mata_kuliah WHERE kode_mk = ?";
        $stmtMkDetail = $conn->prepare($queryMkDetail);
        $stmtMkDetail->bind_param('s', $kodeMk);
        $stmtMkDetail->execute();
        $resultMkDetail = $stmtMkDetail->get_result();
        $mkDetail = $resultMkDetail->fetch_assoc();
        $stmtMkDetail->close();

        // Lakukan insert ke dalam tabel submit_tugas
        $queryInsert = "INSERT INTO submit_tugas (kode_tugas, id_mahasiswa, submission_status, grading, File_submissions, kode_mk)
        VALUES (?, ?, 'Belum Dinilai', 0, ?, ?)";
        $stmtInsert = $conn->prepare($queryInsert);
        $stmtInsert->bind_param('siss', $kodeTugas, $idMahasiswa, $fileTugas, $kodeMk);

        if ($stmtInsert->execute()) {
            echo "Tugas berhasil diupload.";
        } else {
            echo "Error: " . $stmtInsert->error;
        }

        $stmtInsert->close();
    } else {
        echo "Kode Tugas dan File Tugas harus diisi.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Tugas</title>
    <style>
        /* CSS to style the form and its elements */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus {
            color: #495057;
            background-color: #fff;
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            color: #212529;
            text-align: center;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            color: #fff;
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
  <div class="container">
    <h2>Pilih Tugas</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label>Kode Tugas:</label>
        <select name="kode_tugas">
            <?php
            $sql = "SELECT kode_tugas FROM tugas";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row["kode_tugas"] . "'>" . $row["kode_tugas"] . "</option>";
                }
            } else {
                echo "<option value=''>Tidak ada tugas yang tersedia.</option>";
            }
            ?>
        </select>
        <br>
        <label>File Tugas:</label>
        <input type="text" name="file_tugas">
        <br>
        <input type="submit" name="submit" value="Upload">
    </form>
    <div class="mt-4">
            <a href="mahasiswa.php" class="btn btn-primary">Kembali ke Dashboard</a>
        </div>
  </div>
</body>
</html>
