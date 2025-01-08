<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Pembayaran</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <h2 class="mb-4">Form Pembayaran</h2>
    <form action="process_payment.php" method="POST" enctype="multipart/form-data">
      <!-- Upload Foto Bukti Pembayaran -->
      <div class="mb-3">
        <label for="paymentProof" class="form-label">Upload Bukti Pembayaran</label>
        <input type="file" class="form-control" id="paymentProof" name="paymentProof" required>
      </div>

      <!-- Metode Pembayaran -->
      <div class="mb-3">
        <label for="paymentMethod" class="form-label">Metode Pembayaran</label>
        <select class="form-select" id="paymentMethod" name="paymentMethod" required>
          <option value="transfer">Transfer ke BNI 1799721389</option>
          <option value="transfer">Transfer ke DANA 083152637488</option>
          <option value="cod">Cash on Delivery (COD)</option>
        </select>
      </div>

      <!-- Alamat -->
      <div class="mb-3">
        <label for="address" class="form-label">Alamat</label>
        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
      </div>

      <!-- Tombol Submit -->
        <input type="submit" value="Simpan" name="proses">
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php



if(isset($_POST['proses'])){
    mysqli_query($koneksi,"insert into pembayaran set
    bukti_transfer = '$_POST[paymentProof]',
    metode_pembayaran = '$_POST[paymentMethod]',
    alamat = '$_POST[address]'");

    echo "Selesai";
}

?>