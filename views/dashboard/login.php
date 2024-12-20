<?php
session_start();
include_once '../config/app.php';

$_SESSION['csrf_token'] ??= bin2hex(random_bytes(32));

if (isset($_SESSION['user'])) {
    $redirectUrl = empty($result['user']['id_pelanggan']) ? './' :
        getBaseUrl();
    header("Location: $redirectUrl");
    exit;
}

$cAuth = new AuthController();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['message'] = 'Token CSRF tidak valid';
        exit;
    }

    $data = $_POST;
    $result = $cAuth->masuk($data['email'], $data['password']);

    if (empty($result) || !isset($result['icon'], $result['message'])) {
        $errors = $result;
    } else {
        $_SESSION['icon_message'] = $result['icon'];
        $_SESSION['message'] = $result['message'];
        $_SESSION['user'] = $result['user'];

        $redirectUrl = empty($result['user']['id_pelanggan']) ? './' :
            getBaseUrl();
        header("Location: $redirectUrl");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $app_name ?> | Login</title>
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

<body class="hold-transition login-page">
    <div class="login-box" style="position:relative">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="index/dashboard" class="h1"><b><?= $app_name
                                                        ?></b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <?php if (
                    isset($_SESSION['icon_message']) &&
                    isset($_SESSION['message'])
                ) { ?>
                    <div
                        class="alert alert-<?= $_SESSION['icon_message'] ===
                                                'error' ? 'danger' : 'success' ?> alert-dismissible">
                        <button type="button" class="close" data
                            dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-ban"></i> <?=
                                                            $_SESSION['icon_message'] ?>!</h5>
                        <?= $_SESSION['message'] ?>
                    </div>
                <?php
                    unset($_SESSION['icon_message']);
                    unset($_SESSION['message']);
                } ?>
                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" required
                            placeholder="Email" name="email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" required
                            placeholder="Password" name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <input type="hidden" name="csrf_token" value="<?=
                                                                            $_SESSION['csrf_token']; ?>">
                            <button type="submit" class="btn btn-primary btn
block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mb-1">
                    <a href="forgot-password.php">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="register.php" class="text-center">Register a new
                        membership</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
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