<?php
session_start();
// include_once '../../config/app.php';
include_once './app/controllers/PembayaranController.php';
include_once './app/models/Pembayaran.php';


$cPembayaran = new PembayaranController();

// Ambil semua data pembayaran
$dataPembayaran = $cPembayaran->getAllPembayaran();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5">
    <h2>Dashboard Pembayaran</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Alamat</th>
                <th>Metode Pembayaran</th>
                <th>Foto Bukti Transfer</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($dataPembayaran)): ?>
                <?php foreach ($dataPembayaran as $key => $data): ?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= htmlspecialchars($data['alamat']) ?></td>
                        <td><?= htmlspecialchars($data['metode_pembayaran']) ?></td>
                        <td>
                            <a href="<?= htmlspecialchars($data['foto_bukti_transfer']) ?>" target="_blank">
                                <img src="<?= htmlspecialchars($data['foto_bukti_transfer']) ?>" alt="Bukti Transfer" width="100">
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data pembayaran</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
