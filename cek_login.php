<?php
session_start();

if (isset($_GET['type'])) {
    $userType = $_GET['type'];
} else {
    $userType = '';
}

// Sesuaikan dengan struktur database Anda
$dsnLoginLink = 'cek_login.php?type=dosen';
$mhsLoginLink = 'cek_login.php?type=mahasiswa';

if ($userType === 'dosen') {
    $loginLink = $dsnLoginLink;
    $pageTitle = 'Dosen Login';
} elseif ($userType === 'mahasiswa') {
    $loginLink = $mhsLoginLink;
    $pageTitle = 'Mahasiswa Login';
} else {
    // Redirect to the index page if the user type is not specified
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 mx-auto"> <!-- Tambahkan mx-auto di sini -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center"><?= $pageTitle ?></h3>
                    </div>
                    <div class="card-body">
                        <form action="proses_login.php?type=<?= $userType ?>" method="post">
                            <!-- Add your login form fields here -->
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <!-- Bagian HTML pada formulir login -->
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary btn-sm" type="button" id="togglePassword">Tampilkan</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Bagian JavaScript untuk toggle password -->
                            <script>
                                document.getElementById('togglePassword').addEventListener('click', function () {
                                    const passwordInput = document.getElementById('password');
                                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                                    passwordInput.setAttribute('type', type);
                                    this.textContent = type === 'password' ? 'Tampilkan': 'Sembunyikan';
                                });
                            </script>

                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="<?= $userType === 'dosen' ? $mhsLoginLink : $dsnLoginLink ?>">
                                Switch to <?= $userType === 'dosen' ? 'Mahasiswa' : 'Dosen' ?> Login
                            </a>
                        </div>
                        <!-- Display error message -->
                        <?php
                        if (isset($_GET['error'])) {
                            echo '<div class="alert alert-danger mt-3" role="alert">' . htmlspecialchars($_GET['error']) . '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
