<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem E-Learning</title>
    <link rel="stylesheet" href="bootstrap\css\bootstrap.min.css">
    <style>
        body {
            font-family: "Roboto", sans-serif;
            background-color: #fff; }

        p {
            color: #b3b3b3;
            font-weight: 300; }

        h1, h2, h3, h4, h5, h6,
        .h1, .h2, .h3, .h4, .h5, .h6 {
            font-family: "Roboto", sans-serif; }

        a {
            -webkit-transition: .3s all ease;
            -o-transition: .3s all ease;
            transition: .3s all ease; }
            a:hover {
                text-decoration: none !important; }

        .content {
            padding: 7rem 0; }

        h2 {
            font-size: 20px; }

        .half, .half .container > .row {
            height: 100vh; }

        @media (max-width: 991.98px) {
            .half .bg {
                height: 500px; } }

        .half .contents, .half .bg {
            width: 50%; }
            @media (max-width: 1199.98px) {
                .half .contents, .half .bg {
                    width: 100%; } }
            .half .contents .form-group, .half .bg .form-group {
                margin-bottom: 0;
                border: 1px solid #efefef;
                padding: 15px 15px;
                border-bottom: none; }
                .half .contents .form-group.first, .half .bg .form-group.first {
                    border-top-left-radius: 7px;
                    border-top-right-radius: 7px; }
                .half .contents .form-group.last, .half .bg .form-group.last {
                    border-bottom: 1px solid #efefef;
                    border-bottom-left-radius: 7px;
                    border-bottom-right-radius: 7px; }
                .half .contents .form-group label, .half .bg .form-group label {
                    font-size: 12px;
                    display: block;
                    margin-bottom: 0;
                    color: #b3b3b3; }
            .half .contents .form-control, .half .bg .form-control {
                border: none;
                padding: 0;
                font-size: 20px;
                border-radius: 0; }
                .half .contents .form-control:active, .half .contents .form-control:focus, .half .bg .form-control:active, .half .bg .form-control:focus {
                    outline: none;
                    -webkit-box-shadow: none;
                    box-shadow: none; }

        .half .bg {
            background-size: cover;
            background-position: center; }

        .half a {
            color: #888;
            text-decoration: underline; }

        .half .btn {
            height: 54px;
            padding-left: 30px;
            padding-right: 30px; }

        .half .forgot-pass {
            position: relative;
            top: 2px;
            font-size: 14px; }

        .control {
            display: block;
            position: relative;
            padding-left: 30px;
            margin-bottom: 15px;
            cursor: pointer;
            font-size: 14px; }
            .control .caption {
                position: relative;
                top: .2rem;
                color: #888; }

        .control input {
            position: absolute;
            z-index: -1;
            opacity: 0; }

        .control__indicator {
            position: absolute;
            top: 2px;
            left: 0;
            height: 20px;
            width: 20px;
            background: #e6e6e6;
            border-radius: 4px; }

        .control--radio .control__indicator {
            border-radius: 50%; }

        .control:hover input ~ .control__indicator,
        .control input:focus ~ .control__indicator {
            background: #ccc; }

        .control input:checked ~ .control__indicator {
            background: #007bff; }

        .control:hover input:not([disabled]):checked ~ .control__indicator,
        .control input:checked:focus ~ .control__indicator {
            background: #1a88ff; }

        .control input:disabled ~ .control__indicator {
            background: #e6e6e6;
            opacity: 0.9;
            pointer-events: none; }

        .control__indicator:after {
            font-family: 'icomoon';
            content: '\e5ca';
            position: absolute;
            display: none;
            font-size: 16px;
            -webkit-transition: .3s all ease;
            -o-transition: .3s all ease;
            transition: .3s all ease; }

        .control input:checked ~ .control__indicator:after {
            display: block;
            color: #fff; }

        .control--checkbox .control__indicator:after {
            top: 50%;
            left: 50%;
            margin-top: -1px;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%); }

        .control--checkbox input:disabled ~ .control__indicator:after {
            border-color: #7b7b7b; }

        .control--checkbox input:disabled:checked ~ .control__indicator {
            background-color: #7e0cf5;
            opacity: .2; }
    </style>
</head>
<body>
    <?php
    require 'koneksi.php';

    $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
    
        $query = "SELECT * FROM mahasiswa WHERE email = '$email' AND password_mhs = '$password'";
        $result = $conn->query($query);
    
        if ($result->num_rows > 0) {
            $mahasiswa = $result->fetch_assoc();
            $namaMahasiswa = $mahasiswa['nama'];
            header('Location: mahasiswa.php?nama_mhs='.$namaMahasiswa.'');
            exit();
        } else {
            $message = 'Email atau password salah.';
        }
    } else {
        $message = '';
    }
    ?>

    <div class="d-lg-flex half">
        <div class="bg order-1 order-md-2" style="background-image: url('asset/rektorat_unnes.jpg')"></div>
        <div class="contents order-2 order-md-1">
        <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7">
            <h3>Login to <strong>Unnes E-Learning</strong></h3>
            <form action="index.php" method="POST">
              <div class="form-group first">
                <label for="username">Username</label>
                <input type="text" class="form-control" placeholder="your-email@gmail.com" id="username">
              </div>
              <div class="form-group last mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" placeholder="Your Password" id="password">
              </div>
              <input type="submit" value="Log In" class="btn btn-block btn-primary">
              <?php if (!empty($message)): ?>
                        <div class="mt-3 text-red-500"><?php echo $message; ?></div>
            <?php endif; ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>