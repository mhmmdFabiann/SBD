<?php
require_once('koneksi.php');

// Check if the form is submitted for updating the grade
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kodeTugas = $_POST['kode_tugas'];
    $idMahasiswa = $_POST['id_mahasiswa'];
    $nilai = $_POST['nilai'];

    // Update the grade in the database
    $queryUpdateGrade = "UPDATE submit_tugas SET grading = ? WHERE kode_tugas = ? AND id_mahasiswa = ?";
    $stmtUpdateGrade = $conn->prepare($queryUpdateGrade);
    $stmtUpdateGrade->bind_param('sss', $nilai, $kodeTugas, $idMahasiswa);
    $stmtUpdateGrade->execute();
    $stmtUpdateGrade->close();
}

// Retrieve kode_tugas from the URL
$kodeTugas = $_GET['kode_tugas'];

// Fetch submit data for the specific task from the database
$querySubmitData = "SELECT * FROM submit_tugas WHERE kode_tugas = ?";
$stmtSubmitData = $conn->prepare($querySubmitData);
$stmtSubmitData->bind_param('s', $kodeTugas);
$stmtSubmitData->execute();
$resultSubmitData = $stmtSubmitData->get_result();
$submitData = $resultSubmitData->fetch_all(MYSQLI_ASSOC);
$stmtSubmitData->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Tugas</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                Submit Tugas
                <div>
                    <a href="dashboard_dosen.php" class="btn btn-danger">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($submitData)): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kode Tugas</th>
                                <th>NIM</th>
                                <th>Lampiran</th>
                                <th>Status Submit</th>
                                <th>Input Nilai</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($submitData as $submit): ?>
                                <tr>
                                    <td><?= $submit['kode_tugas'] ?></td>
                                    <td><?= $submit['id_mahasiswa'] ?></td>
                                    <td><?= $submit['File_submissions'] ?></td>
                                    <td><?= $submit['submission_status'] ?></td>
                                    <td>
                                        <?php if (empty($submit['grading'])): ?>
                                            <form method="post">
                                                <input type="hidden" name="kode_tugas" value="<?= $submit['kode_tugas'] ?>">
                                                <input type="hidden" name="id_mahasiswa" value="<?= $submit['id_mahasiswa'] ?>">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="nilai" placeholder="Input Nilai" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-sm">Submit Nilai</button>
                                            </form>
                                        <?php else: ?>
                                            <?= $submit['grading'] ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($submit['grading'])): ?>
                                            <!-- Display an "Edit" button -->
                                            <form method="post">
                                                <input type="hidden" name="kode_tugas" value="<?= $submit['kode_tugas'] ?>">
                                                <input type="hidden" name="id_mahasiswa" value="<?= $submit['id_mahasiswa'] ?>">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="nilai" placeholder="Edit Nilai" required>
                                                </div>
                                                <button type="submit" class="btn btn-warning btn-sm">Edit Nilai</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="card-text">Tidak ada data submit tugas untuk tugas ini.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<!-- Tombol kembali ke halaman mata kuliah -->

    <!-- Bootstrap JS and Popper.js (for Bootstrap) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
