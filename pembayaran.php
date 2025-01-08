<?php
session_start();
include_once './config/app.php';

$cPembayaran = new PembayaranController();
$errors = [];

// Proses form pembayaran
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $cPembayaran->tambahPembayaran($_POST, $_FILES);

    if (is_array($result)) {
        $errors = $result; // Validasi gagal
    } else {
        $_SESSION['message'] = $result ? 'Pembayaran berhasil disimpan!' : 'Pembayaran gagal disimpan.';
        $_SESSION['icon_message'] = $result ? 'success' : 'error';

        // Tambahkan kalimat konfirmasi
        echo "<div class='alert alert-success mt-3'>Anda telah melakukan pembayaran</div>";
    }
}

// Ambil semua data pembayaran untuk ditampilkan
$dataPembayaran = $cPembayaran->semuaPembayaran();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Form Pembayaran</h2>
        <form action="" method="POST" enctype="multipart/form-data">

            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control <?= isset($errors['alamat']) ? 'is-invalid' : ''; ?>" id="alamat" name="alamat">
                <?php if (isset($errors['alamat'])): ?>
                    <div class="invalid-feedback"><?= $errors['alamat'] ?></div>
                <?php endif; ?>
            </div>

            <!-- Metode Pembayaran -->
            <div class="mb-3">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                <select class="form-control <?= isset($errors['metode_pembayaran']) ? 'is-invalid' : ''; ?>" id="metode_pembayaran" name="metode_pembayaran">
                    <option value="">Pilih Metode Pembayaran</option>
                    <option value="Transfer Bank">Transfer Bank BNI 1799721389 </option>
                    <option value="E-Wallet">Dana 083152637488</option>
                    <option value="COD">COD</option>
                </select>
                <?php if (isset($errors['metode_pembayaran'])): ?>
                    <div class="invalid-feedback"><?= $errors['metode_pembayaran'] ?></div>
                <?php endif; ?>
            </div>

            <!-- Foto Bukti Transfer -->
            <div class="mb-3">
                <label for="foto_bukti_transfer" class="form-label">Foto Bukti Transfer</label>
                <input type="file" class="form-control <?= isset($errors['foto_bukti_transfer']) ? 'is-invalid' : ''; ?>" id="foto_bukti_transfer" name="foto_bukti_transfer">
                <?php if (isset($errors['foto_bukti_transfer'])): ?>
                    <div class="invalid-feedback"><?= $errors['foto_bukti_transfer'] ?></div>
                <?php endif; ?>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="btn btn-primary">Kirim Pembayaran</button>
        </form>

        <!-- Tabel Data Pembayaran -->
        <h2 class="mt-5">Data Pembayaran</h2>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>ID Pembayaran</th>
                    <th>Alamat</th>
                    <th>Metode Pembayaran</th>
                    <th>Bukti Transfer</th>

                </tr>
            </thead>
            <tbody>
                <?php if (!empty($dataPembayaran)): ?>
                    <?php foreach ($dataPembayaran as $pembayaran): ?>
                        <tr>
                            <td><?= $pembayaran['id']; ?></td>
                            <td><?= htmlspecialchars($pembayaran['alamat']); ?></td>
                            <td><?= htmlspecialchars($pembayaran['metode_pembayaran']); ?></td>
                            <td><img src="<?= $pembayaran['foto_bukti_transfer']; ?>" alt="foto" class="img-fluid"
                                    style="max-width: 100px">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data pembayaran yang ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>