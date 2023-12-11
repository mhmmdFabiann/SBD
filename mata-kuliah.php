<?php
session_start();
if (!isset($_SESSION['userType']) && !isset($_SESSION['userEmail'])) {
    header("Location: cek_login.php");
    exit();
}
$kodeMk = $_GET['kode_mk'];
$mhsEmail = $_SESSION['userEmail'];
// Ambil data mata kuliah dari database
require_once('koneksi.php'); // Sesuaikan dengan file koneksi Anda

$queryMahasiswa = "SELECT id_mahasiswa FROM mahasiswa WHERE email_mhs = ?";
$stmtMahasiswa = $conn->prepare($queryMahasiswa);
$stmtMahasiswa->bind_param('s', $mhsEmail);
$stmtMahasiswa->execute();
$resultMahasiswa = $stmtMahasiswa->get_result();
$mahasiswaData = $resultMahasiswa->fetch_assoc();
$stmtMahasiswa->close();

$idMahasiswa = $mahasiswaData['id_mahasiswa'];

$queryMkDetail = "SELECT * FROM mata_kuliah WHERE kode_mk = ?";
$stmtMkDetail = $conn->prepare($queryMkDetail);
$stmtMkDetail->bind_param('s', $kodeMk);
$stmtMkDetail->execute();
$resultMkDetail = $stmtMkDetail->get_result();
$mkDetail = $resultMkDetail->fetch_assoc();
$stmtMkDetail->close();

// Ambil data tugas dari database
$queryTugas = "SELECT * FROM tugas WHERE kode_mk = ?";
$stmtTugas = $conn->prepare($queryTugas);
$stmtTugas->bind_param('s', $kodeMk);
$stmtTugas->execute();
$resultTugas = $stmtTugas->get_result();
$tugasData = $resultTugas->fetch_all(MYSQLI_ASSOC);
$stmtTugas->close();

// Ambil lampiran materi pembelajaran
$queryLampiran = "SELECT * FROM materi_pembelajaran WHERE kode_mk = ?";
$stmtLampiran = $conn->prepare($queryLampiran);
$stmtLampiran->bind_param('s', $kodeMk);
$stmtLampiran->execute();
$resultLampiran = $stmtLampiran->get_result();
$lampiranData = $resultLampiran->fetch_all(MYSQLI_ASSOC);
$stmtLampiran->close();

$querySubmittedTugas = "SELECT * FROM submit_tugas WHERE kode_tugas = ?";
$stmtSubmittedTugas = $conn->prepare($querySubmittedTugas);
$stmtSubmittedTugas->bind_param('s', $tugas['kode_tugas']);
$stmtSubmittedTugas->execute();
$resultSubmittedTugas = $stmtSubmittedTugas->get_result();
$submittedTugasData = $resultSubmittedTugas->fetch_all(MYSQLI_ASSOC);
$stmtSubmittedTugas->close();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mata Kuliah Detail</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>
<body class="bg-gray-200 p-0 m-0 flex items-center justify-center flex-col">
    <?php
    require 'koneksi.php';

    // Periksa apakah parameter kode_mk ada dalam URL
    if (isset($_GET['kode_mk'])) {
        $kode_mk = $_GET['kode_mk'];

        // Ambil data mata kuliah berdasarkan kode_mk
        $query_mata_kuliah = "SELECT * FROM mata_kuliah WHERE kode_mk = '$kode_mk'";
        $result_mata_kuliah = mysqli_query($conn, $query_mata_kuliah);

        // Periksa apakah mata kuliah dengan kode_mk tersebut ada
        if (mysqli_num_rows($result_mata_kuliah) > 0) {
            $data_mata_kuliah = mysqli_fetch_assoc($result_mata_kuliah);
            $namaMahasiswa = isset($_GET['nama_user']) ? $_GET['nama_user'] : 'Nama User';
        ?>
            <div class="p-3 bg-gradient-to-r from-indigo-600 via-blue-600 to-yellow-300 text-slate-100 text-2xl flex w-full justify-between">
                <header class="text-center">
                    <img src="unnes_header.png" alt="Header Image" class="w-full">
                </header>
                <h2 class="font-bold text-start ml-3">Learning Management System</h2>
                <div class="flex items-center text-end">
                    <i class="bi bi-person me-2 mb-2"></i>
                    <h2 class="font-bold text-sm me-3"><?php echo $namaMahasiswa; ?></h2>
                </div>
            </div>

            <div class="matakuliah pt-10 flex justify-center flex-col">
                <h1 class="text-2xl font-bold text-center mb-10"><?php echo $data_mata_kuliah['nama_mk']; ?></h1>

                <?php
                // Ambil data materi pembelajaran berdasarkan kode_mk
                $query_materi = "SELECT * FROM materi_pembelajaran WHERE kode_mk = '$kode_mk'";
                $result_materi = mysqli_query($conn, $query_materi);
                ?>
                <div class="m-4">
                    <h2 class="text-2xl font-bold mb-3">Materi Pembelajaran</h2>
                    <table class="min-w-full border border-gray-300">
                        <thead>
                            <tr>
                                <th class="border border-gray-300 px-4 py-2">Nama Materi</th>
                                <th class="border border-gray-300 px-4 py-2">Lampiran Materi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($data_materi = mysqli_fetch_assoc($result_materi)) {
                                echo "<tr>";
                                echo "<td class='border border-gray-300 px-4 py-2'>".$data_materi['nama_materi']."</td>";
                                echo "<td class='border border-gray-300 px-4 py-2'>".$data_materi['lampiran_materi']."</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="m-4">
                    <h2 class="text-2xl font-bold mb-3">Tugas</h2>

                    <?php
                    // Ambil data tugas berdasarkan kode_mk
                    $query_tugas = "SELECT * FROM tugas WHERE kode_mk = '$kode_mk'";
                    $result_tugas = mysqli_query($conn, $query_tugas);

                    if (mysqli_num_rows($result_tugas) > 0) {
                    ?>
                    <table class="min-w-full border border-gray-300">
                        <thead>
                            <tr>
                                <th class="border border-gray-300 px-4 py-2">Nama Tugas</th>
                                <th class="border border-gray-300 px-4 py-2">Deadline</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($data_tugas = mysqli_fetch_assoc($result_tugas)) {
                                echo "<tr>";
                                echo "<td class='border border-gray-300 px-4 py-2'>".$data_tugas['nama_tugas']."</td>";
                                echo "<td class='border border-gray-300 px-4 py-2'>".$data_tugas['deadline']."</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                    } else {
                        // Tidak ada tugas yang perlu dikerjakan, hide submission section
                        ?>
                        <style>
                            .submission-section {
                                display: none;
                            }
                        </style>
                        <?php
                    }
                    ?>
                    </div>
                    <div class="m-4 submission-section">
                        <h2 class="text-2xl font-bold mb-5">Submission<a href="upload_tugas.php" class="bg-green-600 p-3 text-white rounded-lg my-5 ml-5 text-sm" tabindex="-1" role="button" aria-disabled="true">Upload Tugas</a></h2>

                        <?php
                        // Ambil data pengumpulan tugas berdasarkan kode_mk dan id_mahasiswa
                        $query_submit_tugas = "SELECT submit_tugas.*, tugas.nama_tugas FROM submit_tugas 
                                                JOIN tugas ON submit_tugas.kode_tugas = tugas.kode_tugas
                                                WHERE submit_tugas.id_mahasiswa = '$idMahasiswa'"; // Change id_mahasiswa accordingly.
                        $result_submit_tugas = mysqli_query($conn, $query_submit_tugas);

                        if (mysqli_num_rows($result_submit_tugas) > 0) {
                        ?>
                        <table class="min-w-full border border-gray-300">
                            <thead>
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2">Nama Tugas</th>
                                    <th class="border border-gray-300 px-4 py-2">Submission Status</th>
                                    <th class="border border-gray-300 px-4 py-2">Grading Status</th>
                                    <th class="border border-gray-300 px-4 py-2">File Submissions</th>
                                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($data_submit_tugas = mysqli_fetch_assoc($result_submit_tugas)) {
                                    echo "<tr>";
                                    echo "<td class='border border-gray-300 px-4 py-2'>".$data_submit_tugas['nama_tugas']."</td>";
                                    echo "<td class='border border-gray-300 px-4 py-2'>".$data_submit_tugas['submission_status']."</td>";
                                    echo "<td class='border border-gray-300 px-4 py-2'>".$data_submit_tugas['grading']."</td>";
                                    echo "<td class='border border-gray-300 px-4 py-2'>".$data_submit_tugas['File_submissions']."</td>";
                                    echo "<td class='border border-gray-300 px-4 py-2'>
                                            <a href='hapus_tugas.php?id=".$data_submit_tugas['id_mengumpulkan_tugas']."' class='text-blue-500'>Hapus</a>
                                        </td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        } else {
                            // Tampilkan pesan jika tidak ada pengumpulan tugas
                            echo "<p class='text-xl font-bold text-red-500'>Belum ada tugas yang dikumpulkan.</p>";
                        }
                        ?>
                    </div>
        <?php
        } else {
            // Tampilkan pesan jika mata kuliah tidak ditemukan
            echo "<div class='text-center p-3 text-white bg-danger'>";
            echo "<h2 class='font-bold'>Mata Kuliah Tidak Ditemukan</h2>";
            echo "</div>";
        }
    } else {
        // Tampilkan pesan jika parameter kode_mk tidak ada dalam URL
        echo "<div class='text-center p-3 text-white bg-danger'>";
        echo "<h2 class='font-bold'>Kode Mata Kuliah Tidak Ditemukan</h2>";
        echo "</div>";
    }
    ?>
    <div class="mt-4">
            <a href="mahasiswa.php" class="btn btn-primary">Kembali ke Dashboard</a>
        </div>
</body>
</html>