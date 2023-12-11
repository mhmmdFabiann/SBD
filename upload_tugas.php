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
    <title>Pilih Tugas</title>
</head>
<body>
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
</body>
</html>
