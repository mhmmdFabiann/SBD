<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<style>
    body {
        background-image: url('./rektorat_unnes.jpg');
        background-size: cover;
        background-position: center;
        height: 100vh;
        margin: 0;
    }

    .container{
        display: flex;
        align-items: center;
        justify-content: center;
    }

</style>
<body>
<?php
require 'koneksi.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';

    if (empty($role)) {
        $message = 'Pilih peran (Mahasiswa/Dosen).';
    } else {
        $query = '';
        $redirectPage = '';

        if ($role == 'mahasiswa') {
            $query = "SELECT * FROM mahasiswa WHERE email_mhs = '$email' AND password_mhs = '$password'";
            $redirectPage = 'mahasiswa.php';
        } elseif ($role == 'dosen') {
            $query = "SELECT * FROM dosen WHERE email_dsn = '$email' AND password_dsn = '$password'";
            $redirectPage = 'dosen.php';
        }

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $namaUser = ($role == 'mahasiswa') ? $user['nama'] : $user['nama_dsn'];
            header("Location: $redirectPage?nama_user=$namaUser");
            exit();
        } else {
            $message = 'Email atau password salah.';
        }
    }
} else {
    $message = '';
}
?>

<body>
    <center>
    <div class="container flex items-center h-screen">
        <div class="w-96">
            <div class="bg-slate-100 shadow-md rounded-md p-4">
                <div class="text-slate-300 text-center py-2 mb-4 rounded-md">
                    <h2 class="text-lg font-semibold text-black">Login</h2>
                </div>
                <form action="index.php" method="POST" role="form">
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                        <input type="email" name="email" id="email" class="w-full mt-1 p-2 border-2 border-slate-400 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                        <input type="password" name="password" id="password" class="w-full mt-1 p-2 border-2 border-slate-400 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600">Role</label>
                        <input type="radio" name="role" value="mahasiswa" checked> Mahasiswa
                        <input type="radio" name="role" value="dosen"> Dosen
                    </div>
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Login</button>
                    <?php if (!empty($message)): ?>
                        <div class="mt-3 text-red-500"><?php echo $message; ?></div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
    </center>
</body>
</html>
