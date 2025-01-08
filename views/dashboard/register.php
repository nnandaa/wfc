<?php
session_start();

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

 include '../config/app.php';
$cAuth = new AuthController();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // validasi CSRF token 
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $data = $_POST;
        $result = $cAuth->daftar($data);

        //jika terdapat error 
        if (
            !array_key_exists('icon', $result) &&
            !array_key_exists('message', $result) && !empty($result)
        ) {
            $errors = $result; // simpan error 
        } else {
            $_SESSION['icon_message'] = $result['icon'];
            $_SESSION['message'] = $result['message'];
            header("Location: login.php");  // Redirect after action 
            exit;
        }
    } else {
        $_SESSION['message'] = 'Token CSRF tidak valid';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $app_name ?> | Register</title>
    <link rel="icon" type="image/x-icon" href="<?= $logo ?>">

    <!-- Google Font: Noto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0
 ,14..32,100..900;1,14..32,100..900&family=Noto+Sans:ital,wght@0,100..900;1,10
 0..900&display=swap"
        rel="stylesheet">

    <style>
        body,
        html,
        table {
            font-family: 'Noto', sans-serif !important;
        }
    </style>

    <!-- AdminLTE CDN CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin
lte@3.2/dist/css/adminlte.min.css">
    <!-- Datatables CSS -->
    <link href="https://cdn.datatables.net/v/bs4/dt-2.1.8/datatables.min.css"
        rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/fceaeeb499.js"
        crossorigin="anonymous"></script>
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="index/dashboard" class="h1"><b><?= $app_name
                                                        ?></b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Register a new membership</p>

                <form action="" method="post">
                    <!-- user section -->
                    <div class="input-group mb-3">
                        <input type="text" class="form-control"
                            placeholder="Username" name="username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <?php if (isset($errors['username'])): ?>
                            <span class="error invalid-feedback"
                                style="display: inline;"><?= $errors['username'] ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control"
                            placeholder="Email" name="email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        <?php if (isset($errors['email'])): ?>
                            <span class="error invalid-feedback"
                                style="display: inline;"><?= $errors['email'] ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control"
                            placeholder="Password" name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <?php if (isset($errors['password'])): ?>
                            <span class="error invalid-feedback"
                                style="display: inline;"><?= $errors['password'] ?></span>
                        <?php endif; ?>
                    </div>
                    <hr>
                    <!-- profil section -->
                    <div class="input-group mb-3">
                        <input type="text" class="form-control <?=
                                                                isset($errors['nama']) ? 'is-invalid' : '' ?>"
                            id="nama" name="nama" placeholder="Nama Lengkap">
                        <?php if (isset($errors['nama'])): ?>
                            <span class="error invalid-feedback"
                                style="display: inline;"><?= $errors['nama'] ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control <?=
                                                                isset($errors['telp']) ? 'is-invalid' : '' ?>"
                            id="telp" name="telp" placeholder="No. Telp">
                        <?php if (isset($errors['telp'])): ?>
                            <span class="error invalid-feedback"
                                style="display: inline;"><?= $errors['telp'] ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control <?=
                                                        isset($errors['alamat']) ? 'is-invalid' : '' ?>" id="alamat"
                            name="alamat" rows="3"></textarea>
                        <?php if (isset($errors['alamat'])): ?>
                            <div class="invalid-feedback"><?=
                                                            $errors['alamat'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <input type="hidden" name="csrf_token" value="<?=
                                                                            $_SESSION['csrf_token']; ?>">
                            <button type="submit" class="btn btn-primary btn
block">Register</button>
                        </div>
                    </div>
                </form>

                <a href="login.php" class="text-center">I already have a
                    membership</a>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
    <!-- Bootstrap 4 -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.mi
 n.js"
        integrity="sha384
Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin
lte@3.2/dist/js/adminlte.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/fceaeeb499.js"
        crossorigin="anonymous"></script>
</body>

</html>