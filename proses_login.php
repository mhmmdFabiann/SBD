<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sesuaikan dengan struktur database Anda
    require_once("koneksi.php"); // Gantilah dengan koneksi database yang sesuai

    // Ambil data dari form
    $email = $_POST["email"];
    $password = $_POST["password"];
    $userType = $_GET["type"];
    
    // Sesuaikan dengan nama tabel login yang sesuai di database Anda
    $loginTable = "login";

    // Query untuk mengambil data login
    $query = "SELECT * FROM $loginTable WHERE ";
    $query .= ($userType === "dosen") ? "email_dsn" : "email_mhs";
    $query .= " = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPassword = ($userType === "dosen") ? $row["password_dsn"] : $row["password_mhs"];
        // Sesuaikan dengan kebijakan keamanan password Anda
        if ($password === $storedPassword) {
            // Login sukses, arahkan pengguna ke halaman dashboard sesuai tipe pengguna
            $_SESSION['userType'] = $userType;
            $_SESSION['userEmail'] = $email;
            header("Location: dashboard_" . $userType . ".php");
            exit();
        } else {
            // Password tidak sesuai
            $error = "Password salah!";
        }
    } else {
        // Email tidak ditemukan
        $error = "Email tidak ditemukan!";
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirect jika bukan POST request
    header("Location: index.php");
    exit();
}

// Redirect dengan pesan kesalahan
header("Location: cek_login.php?type=$userType&error=" . urlencode($error));
exit();

?>