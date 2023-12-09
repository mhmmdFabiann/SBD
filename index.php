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


        .contents .btn {
            height: 54px;
            padding-left: 30px;
            padding-right: 30px;
            color: #fff; /* Menambahkan warna putih pada teks tombol */
        }

        .contents .btn-primary {
            background-color: #007bff; /* Warna tombol untuk Dosen */
        }

        .contents .btn-success {
            background-color: #28a745; /* Warna tombol untuk Mahasiswa */
        }

    </style>
</head>
<body>
<div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('asset/rektorat_unnes.jpg')"></div>
    <div class="contents order-2 order-md-1">
        <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7">
            <h3>Login to <strong>Unnes</strong></h3>
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

</body>
</html>