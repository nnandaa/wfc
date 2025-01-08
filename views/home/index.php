<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk dan Kategori</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php
    // Pastikan Anda sudah menginisialisasi objek $cHome sebelumnya di file utama
    // Misalnya: $cHome = new SomeClass();

    // Menangani kategori yang dipilih
    if (isset($_GET['kategori'])) {
        $kategori = $_GET['kategori'];
        // Ambil produk berdasarkan kategori
        $produk = $cHome->produkKategori($kategori);
    } else {
        $produk = $cHome->produkKategori('');
    }
    ?>

    <!-- Bagian Kategori (1 Baris) -->
    <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
        <!-- Tab Semua -->
        <a href="?kategori=semua" class="btn btn-warning text-white fw-bold">Semua</a>
        <!-- Tab Kategori Dinamis -->
        <?php foreach ($cHome->kategoris() as $kategori_item) { ?>
            <a href="?kategori=<?= $kategori_item['nama'] ?>" class="btn btn-warning text-white fw-bold">
                <?= $kategori_item['nama'] ?>
            </a>
        <?php } ?>
    </div>

    <!-- Bagian Produk Berdasarkan Kategori -->
    <div class="overflow-y-scroll overflow-x-hidden py-4 px-4 rounded" style="max-height: 600px;">
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
            <?php
            // Jika tidak ada produk yang ditemukan
            if (empty($produk)) { ?>
                <div class="col-12 text-center">
                    <div class="alert alert-warning" role="alert">
                        Produk belum tersedia
                    </div>
                </div>
            <?php } else
                foreach ($produk as $p) { ?>
                <div class="col">
                    <div class="card text-center p-3 shadow-sm h-100" style="background-color: #FFA825; color: white;">
                        <div class="card-body">
                            <!-- Gambar Produk -->
                            <img src="<?= $p['photo']; ?>" class="rounded card-img-top" style="height: 150px; object-fit: cover;" alt="<?= $p['nama']; ?>">
                            <span class="position-absolute top-0 end-0 bg-danger px-1 rounded-end-2 rounded-bottom-0 fw-semibold">
                                <?= $p['nama_kategori'] ?>
                            </span>
                            <!-- Nama Produk -->
                            <p class="card-text fw-bold fs-4 mt-3">
                                <?= $p['nama']; ?>
                            </p>
                            <!-- Deskripsi Produk -->
                            <p class="card-text lead fs-6">
                                <?= $p['deskripsi']; ?>
                            </p>
                            <!-- Stock dan Harga -->
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-body-secondary text-dark">
                                    Stock: <?= $p['stock']; ?>
                                </small>
                                <p class="card-text mb-1 text-success fw-bold fs-4 text-end">
                                    Rp. <?= number_format($p['harga'], 0, ',', '.'); ?>
                                </p>
                            </div>
                        </div>

                        <!-- Bagian Keranjang (Jika Login) -->
                        <?php if (isset($_SESSION['user'])): ?>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <form action="" method="POST" style="display:inline-block;" onsubmit="return confirm('Tambahkan item ini ke keranjang ?');">
                                        <input type="hidden" name="id_produk" value="<?= $p['id']; ?>">
                                        <input type="hidden" value="addKeranjang" name="aksi">
                                        <div class="input-group mb-2 justify-content-center">
                                            <input type="number" class="form-control" name="jumlah" id="jumlah" min="0" value="0" required aria-describedby="button-addon2">
                                            <button class="btn btn-sm btn-success" type="submit" id="button-addon2">
                                                <i class="bi bi-cart-plus-fill me-1"></i>Keranjang
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>