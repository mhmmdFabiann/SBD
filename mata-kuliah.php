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

                <?php
                // Ambil data tugas berdasarkan kode_mk
                $query_tugas = "SELECT tugas.*, GROUP_CONCAT(submit_tugas.lampiran_tugas SEPARATOR ', ') AS lampiran_tugas
                                FROM tugas
                                LEFT JOIN submit_tugas ON tugas.kode_tugas = submit_tugas.kode_tugas
                                WHERE tugas.kode_mk = '$kode_mk'
                                GROUP BY tugas.kode_tugas";
                $result_tugas = mysqli_query($conn, $query_tugas);
                ?>
                <div class="m-4">
                    <h2 class="text-2xl font-bold mb-3">Tugas</h2>

                    <?php
                    if (mysqli_num_rows($result_tugas) > 0) {
                    ?>
                    <table class="min-w-full border border-gray-300">
                        <thead>
                            <tr>
                                <th class="border border-gray-300 px-4 py-2">Nama Tugas</th>
                                <th class="border border-gray-300 px-4 py-2">Deadline</th>
                                <th class="border border-gray-300 px-4 py-2">Lampiran Tugas</th>
                                <th class="border border-gray-300 px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($data_tugas = mysqli_fetch_assoc($result_tugas)) {
                                echo "<tr>";
                                echo "<td class='border border-gray-300 px-4 py-2'>".$data_tugas['nama_tugas']."</td>";
                                echo "<td class='border border-gray-300 px-4 py-2'>".$data_tugas['deadline']."</td>";
                                echo "<td class='border border-gray-300 px-4 py-2'><?php echo $data_tugas[lampiran_tugas]; ?></td>";
                                echo "<td class='border border-gray-300 px-4 py-2'><a href='upload_tugas.php?id_tugas=" . $data_tugas['kode_tugas'] . "&nama_user=" . urlencode($namaMahasiswa) . "' class='bg-blue-500 text-white px-4 py-2 rounded'>Upload Tugas</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <?php
                    } else {
                        // Tampilkan pesan jika tidak ada tugas
                        echo "<p class='text-xl font-bold text-red-500'>Tidak ada tugas untuk mata kuliah ini.</p>";
                    }
                    ?>
                </div>
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
</body>
</html>
