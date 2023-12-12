<?php
// Tambahkan kode ini di awal file edit_materi.php
session_start();
if (!isset($_SESSION['userType']) && !isset($_SESSION['userEmail'])) {
    header("Location: cek_login.php");
    exit();
}

require_once('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['kode_materi'])) {
    $kode_materi = $_GET['kode_materi'];
    $sql = "SELECT * FROM materi_pembelajaran WHERE kode_materi = '$kode_materi'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama_materi = $row['nama_materi'];
        $lampiran_materi = $row['lampiran_materi'];
        $kode_mk = $row['kode_mk'];
    } else {
        echo "Materi not found";
        exit();
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kode_materi'])) {
    $kode_materi = $_POST['kode_materi'];
    $nama_materi = $_POST['nama_materi'];
    $lampiran_materi = $_POST['lampiran_materi'];
    $kode_mk = $_POST['kode_mk'];

    $sql = "UPDATE materi_pembelajaran
            SET nama_materi='$nama_materi', lampiran_materi='$lampiran_materi', kode_mk='$kode_mk'
            WHERE kode_materi='$kode_materi'";

    if ($conn->query($sql) === TRUE) {

        header("Location: matkul.php?kode_mk=$kode_mk");
exit();
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
    <title>Edit Materi</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007bff;
            text-align: center;
        }
        label {
            margin-top: 10px;
            display: block;
            color: #495057;
        }
        input.form-control {
            margin-bottom: 15px;
        }
        button.btn-success {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Materi</h2>

        <form action="" method="POST">
            <input type="hidden" name="kode_mk" value="<?php echo $kode_mk; ?>">

            <label for="nama_materi">Nama Materi:</label>
            <input type="text" class="form-control" name="nama_materi" value="<?php echo $nama_materi; ?>" required>

            <label for="lampiran_materi">Lampiran Materi:</label>
            <input type="text" class="form-control" name="lampiran_materi" value="<?php echo $lampiran_materi; ?>">

            <label for="kode_materi">Kode Materi:</label>
            <input type="text" class="form-control" name="kode_materi" value="<?php echo $kode_materi; ?>" required>

            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
</body>
</html>

