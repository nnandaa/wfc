<?php
ob_start();
session_start();

include '../config/app.php';
$_SESSION['csrf_token'] ??= bin2hex(random_bytes(32));

$dashboard = new DashboardController($_SERVER['QUERY_STRING']);
$contentPath = $dashboard->getContentPath();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/x-icon" href="<?= $logo ?>">

    <!-- Google Font: Noto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14.
 .32,100..900;1,14..32,100..900&family=Noto+Sans:ital,wght@0,100..900;1,100..900&d
 isplay=swap"
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
    <link href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/fceaeeb499.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include './layouts/navbar.php'; ?>
        <!-- Main Sidebar Container -->
        <?php include './layouts/sidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><?= htmlspecialchars(ucfirst($dashboard->getMenuName())) ?></h1> 
                        </div> 
                        <div class="col-sm-6"> 
                            <ol class="breadcrumb float-sm-right"> 
                                <li class="breadcrumb-item"> 
                                <a 
                                    href="?menu=<?= urlencode($dashboard->getMenuName()) 
    ?>"><?= htmlspecialchars(ucfirst($dashboard->getMenuName())) ?></a> 
                                </li> 
                                <li class="breadcrumb-item active"> 
                                <?= htmlspecialchars(ucfirst($dashboard->getAksiName())) ?> 
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content --> 
      <div class="content"> 
          <div class="container-fluid"> 
           <?php 
           //mendapatkan last segment dashboard pada url 
           $requestUri = $_SERVER['REQUEST_URI']; 
           $path = trim($requestUri, '/'); 
           $segments = explode('/', $path); 
           $lastSegment = end($segments); 
 
           if (strtolower($lastSegment) === "dashboard") { 
            include './layouts/overview.php'; 
           } elseif (!$contentPath) { 
            include './layouts/404.php'; 
           } elseif ($contentPath) { 
            include $contentPath; 
           } 
           ?> 
          </div> 
      </div> 
        <!-- Main Footer -->
        <?php include './layouts/footer.php'; ?>
    </div>

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
    <!-- Bootstrap 4 -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js
 "
        integrity="sha384
Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin
lte@3.2/dist/js/adminlte.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/fceaeeb499.js"
        crossorigin="anonymous"></script>
    <!-- Datatables -->
    <script src="https://cdn.datatables.net/v/bs4/dt
2.1.8/datatables.min.js"></script>
    <script>
        $('#table').DataTable({
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All']
            ]
        });
    </script>
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if (isset($_SESSION["message"]) && isset($_SESSION["icon_message"])) {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: '<?= ucfirst($_SESSION['icon_message']); ?>',
                    text: '<?= $_SESSION['message']; ?>',
                    icon: '<?= $_SESSION['icon_message']; ?>',
                })
            });
        </script>
    <?php
        unset($_SESSION["message"]);
    } ?>

</body>

</html>

<?php
ob_end_flush(); // End output buffering and send output 
?>