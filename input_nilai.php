<?php
// Include your database connection file
require_once('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $kodeTugas = $_POST['kode_tugas'];
    $idMahasiswa = $_POST['id_mahasiswa'];
    $nilai = $_POST['nilai'];

    // Update grading in the database (adjust the query based on your database structure)
    $queryUpdateGrading = "UPDATE submit_tugas SET grading = ? WHERE kode_tugas = ? AND id_mahasiswa = ?";
    $stmtUpdateGrading = $conn->prepare($queryUpdateGrading);
    $stmtUpdateGrading->bind_param('sss', $nilai, $kodeTugas, $idMahasiswa);

    if ($stmtUpdateGrading->execute()) {
        // Grading updated successfully
        echo "Grading updated successfully.";
    } else {
        // Error updating grading
        echo "Error updating grading: " . $stmtUpdateGrading->error;
    }

    $stmtUpdateGrading->close();
    $conn->close();
} else {
    // Handle non-POST requests if needed
    echo "Invalid request method.";
}
?>
