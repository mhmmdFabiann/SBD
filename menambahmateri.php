<?php
session_start();
if (!isset($_GET['role']) && !isset($_SESSION['userEmail'])) {
    header("Location: cek_login.php");
    exit();
}

// Ambil parameter kode_mk dari URL
$kodeMk = $_GET['kode_tugas'];
// Ambil data mata kuliah dari database
require_once('koneksi.php'); // Sesuaikan dengan file koneksi Anda
$queryMkDetail = "SELECT * FROM tugas WHERE kode_tugas = ?";
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

// Ambil jadwal mata kuliah dari database
$queryJadwal = "SELECT * FROM jadwal WHERE kode_mk = ?";
$stmtJadwal = $conn->prepare($queryJadwal);
$stmtJadwal->bind_param('s', $kodeMk);
$stmtJadwal->execute();
$resultJadwal = $stmtJadwal->get_result();
$jadwalMk = $resultJadwal->fetch_all(MYSQLI_ASSOC);
$stmtJadwal->close();


$conn->close()

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mata Kuliah</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h3 class="mb-4">Detail Mata Kuliah</h3>

        <!-- Tampilkan informasi mata kuliah -->
        <div class="card">
            <div class="card-header">
                Informasi Mata Kuliah
            </div>
            <div class="card-body">
                <p><strong>Nama Mata Kuliah :</strong> <?= $mkDetail['nama_mk'] ?></p>
                <p><strong>Kode Mata Kuliah :</strong> <?= $mkDetail['kode_mk'] ?></p>
                <!-- Tambahkan informasi lainnya sesuai kebutuhan -->
            </div>
        </div>

        <!-- Tampilkan jadwal mata kuliah -->
        <div class="card mt-4">
            <div class="card-header">
                Jadwal Mata Kuliah
            </div>
            <div class="card-body">
                <?php foreach ($jadwalMk as $jadwal): ?>
                    <p><strong>Jam Mulai :</strong> <?= $jadwal['jam_mulai'] ?></p>
                    <p><strong>Jam Selesai :</strong> <?= $jadwal['jam_selesai'] ?></p>
                    <p><strong>Tanggal (YYYY/MM/DD) :</strong> <?= $jadwal['tanggal'] ?></p>
                    <p><strong>Ruang Kelas :</strong> <?= $jadwal['ruang_kelas'] ?></p>
                    <!-- Tambahkan informasi lainnya sesuai kebutuhan -->
                    <hr>
                <?php endforeach; ?>
            </div>
        </div>
            <!-- Daftar Tugas -->
            <div class="card mt-4">
                        <div class="card-header">
                            Daftar Tugas
                            <a href="tugas_mk.php?kode_mk=<?= $mkDetail['kode_mk'] ?>" class="btn btn-danger btn-sm float-right mr-2">Tambah Tugas</a>
                        </div>
                        <div class="card-body">
                            <?php if (empty($tugasData)): ?>
                                <p>Tidak ada tugas untuk mata kuliah ini.</p>
                            <?php else: ?>
                                <ul>
                                    <?php foreach ($tugasData as $tugas): ?>
                                        <li>
                                            <strong><?= $tugas['nama_tugas'] ?></strong>
                                            <br>
                                            Kode Tugas : <?= $tugas['kode_tugas'] ?>
                                            <br>
                                            Deadline : <?= $tugas['deadline'] ?>
                                            <br>
                                            Lampiran : <?= $tugas['lampiran_tugas'] ?>
                                            <br>
                                            <a href="edit_tugas.php?kode_mk=<?= $mkDetail['kode_mk'] ?>&kode_tugas=<?= $tugas['kode_tugas'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                            <a href="hapus_tugas.php?kode_mk=<?= $mkDetail['kode_mk'] ?>&kode_tugas=<?= $tugas['kode_tugas'] ?>" class="btn btn-danger btn-sm">Hapus</a>
                                        </li>
                                        <br>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>

                            <!-- Lampiran Materi Pembelajaran -->
            <div class="card mt-4">
                <div class="card-header">
                    Materi Pembelajaran
                    <a href="tambah_materi.php?kode_mk=<?= $mkDetail['kode_mk'] ?>" class="btn btn-primary btn-sm float-right mr-2">Tambah Materi</a>
                </div>
                <div class="card-body">
                    <?php if (empty($lampiranData)): ?>
                        <p>Tidak ada Materi untuk mata kuliah ini.</p>
                    <?php else: ?>
                        <ul>
                            <?php foreach ($lampiranData as $lampiran): ?>
                                <li>
                                    <strong><?= $lampiran['nama_materi'] ?></strong>
                                    <br>
                                    Kode Materi : <?= $lampiran['kode_materi'] ?>
                                    <br>
                                    Lampiran Materi : <?= $lampiran['lampiran_materi'] ?>
                                    <br>
                                    <a href="edit_materi.php?kode_mk=<?= $mkDetail['kode_mk'] ?>&kode_materi=<?= $lampiran['kode_materi'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="hapus_materi.php?kode_mk=<?= $mkDetail['kode_mk'] ?>&kode_materi=<?= $lampiran['kode_materi'] ?>" class="btn btn-danger btn-sm">Hapus</a>
                                </li>
                                <br>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>

        <!-- Tombol kembali ke dashboard dosen -->
        <div class="mt-4">
            <a href="dosen.php" class="btn btn-primary">Kembali ke Dashboard Dosen</a>
        </div>
    </div>
</body>
</html>