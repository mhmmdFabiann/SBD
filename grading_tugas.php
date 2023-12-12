<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_tugas = $_POST['kode_tugas'];
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $grading = $_POST['grading'];
    $file_submissions = $_POST['file_submissions'];
    $submission_status = $_POST['submission_status'];

    // Update nilai tugas pada tabel submit_tugas
    $update_query = "UPDATE submit_tugas SET grading='$grading', File_submissions='$file_submissions', submission_status='$submission_status'
                    WHERE kode_tugas='$kode_tugas' AND id_mahasiswa='$id_mahasiswa'";

    if ($conn->query($update_query) === TRUE) {
        echo "Nilai berhasil diupdate.";
    } else {
        echo "Error: " . $update_query . "<br>" . $conn->error;
    }
}

if (isset($_GET['kode_tugas'])) {
    $kode_tugas = $_GET['kode_tugas'];

    // Query untuk mendapatkan informasi tugas yang akan dinilai
    $query = "SELECT s.*, m.nama
              FROM submit_tugas s
              JOIN mahasiswa m ON s.id_mahasiswa = m.id_mahasiswa
              WHERE kode_tugas='$kode_tugas'";

    $result = $conn->query($query);
    $tugas = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Tugas</title>
</head>
<body>
    <h2>Nilai Tugas</h2>
    <form method="post" action="">
        <input type="hidden" name="kode_tugas" value="<?php echo $tugas['kode_tugas']; ?>">
        <input type="hidden" name="id_mahasiswa" value="<?php echo $tugas['id_mahasiswa']; ?>">
        
        <label for="grading">Nilai:</label>
        <input type="text" name="grading" value="<?php echo $tugas['grading']; ?>" required>
        
        <label for="file_submissions">File Submissions:</label>
        <input type="text" name="file_submissions" value="<?php echo $tugas['File_submissions']; ?>" required>
        
        <label for="submission_status">Status Submit:</label>
        <input type="text" name="submission_status" value="<?php echo $tugas['submission_status']; ?>" required>

        <button type="submit">Simpan Nilai</button>
    </form>
</body>
</html>