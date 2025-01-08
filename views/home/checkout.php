<?php
session_start();
require_once '../../config/database.php'; // Pastikan Anda sudah menghubungkan database di sini

// Verifikasi CSRF Token
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
    
    // Proses Checkout
    if (isset($_POST['aksi']) && $_POST['aksi'] === 'checkout') {
        // Ambil data pesanan yang dikirimkan
        $pesanan = $_POST['pesanan'] ?? [];
        $totalBelanja = 0;

        // Periksa apakah pesanan kosong
        if (empty($pesanan)) {
            $_SESSION['icon_message'] = 'bi bi-exclamation-circle-fill';
            $_SESSION['message'] = 'Keranjang Anda kosong!';
            header("Location: ?menu=keranjang");
            exit;
        }

        // Transaksi checkout dimulai
        try {
            // Mulai transaksi
            $pdo->beginTransaction();

            // Simpan pesanan utama (tabel orders)
            $stmt = $pdo->prepare("INSERT INTO orders (id_pelanggan, total_belanja, status) VALUES (?, ?, ?)");
            $stmt->execute([$_SESSION['user']['id_pelanggan'], $totalBelanja, 'Pending']);

            // Ambil ID pesanan terakhir yang dimasukkan
            $orderId = $pdo->lastInsertId();

            // Simpan detail pesanan (tabel order_items)
            foreach ($pesanan as $item) {
                $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                $stmt->execute([$orderId, $item['id'], $item['qty'], $item['price']]);

                // Update stok produk setelah pesanan berhasil
                $stmtUpdate = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
                $stmtUpdate->execute([$item['qty'], $item['id']]);
                
                // Hitung total belanja
                $totalBelanja += $item['total'];
            }

            // Perbarui total belanja di tabel orders
            $stmtUpdateOrder = $pdo->prepare("UPDATE orders SET total_belanja = ? WHERE id = ?");
            $stmtUpdateOrder->execute([$totalBelanja, $orderId]);

            // Commit transaksi
            $pdo->commit();

            // Tampilkan pesan sukses
            $_SESSION['icon_message'] = 'bi bi-check-circle-fill';
            $_SESSION['message'] = 'Pesanan Anda telah diproses. Silakan cek status pesanan Anda.';
            header("Location: ?menu=keranjang");
            exit;
        } catch (Exception $e) {
            // Jika ada error, rollback transaksi
            $pdo->rollBack();
            $_SESSION['icon_message'] = 'bi bi-exclamation-circle-fill';
            $_SESSION['message'] = 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage();
            header("Location: ?menu=keranjang");
            exit;
        }
    }
} else {
    // Jika token tidak valid atau request bukan POST
    $_SESSION['icon_message'] = 'bi bi-exclamation-circle-fill';
    $_SESSION['message'] = 'Permintaan tidak valid!';
    header("Location: ?menu=keranjang");
    exit;
}
?>
