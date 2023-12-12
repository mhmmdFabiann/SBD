<?php
require_once('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle the form submission for editing the grade
    $kodeTugas = $_POST['kode_tugas'];
    $idMahasiswa = $_POST['id_mahasiswa'];
    $nilai = $_POST['nilai'];

    // Update the database with the edited grade
    $queryUpdateGrade = "UPDATE submit_tugas SET grading = ? WHERE kode_tugas = ? AND id_mahasiswa = ?";
    $stmtUpdateGrade = $conn->prepare($queryUpdateGrade);
    $stmtUpdateGrade->bind_param('sss', $nilai, $kodeTugas, $idMahasiswa);
    $stmtUpdateGrade->execute();
    $stmtUpdateGrade->close();

    // Redirect back to the original page after the update
    header("Location:lihat_submit.php?kode_tugas=$kodeTugas");
    exit; // Ensure that no further code is executed after redirection
}

// If it's not a POST request or there's an issue, redirect to the main page
header("Location: lihat_submit.php");
exit;
?>
