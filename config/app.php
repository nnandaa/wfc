<?php
//include config
include_once './config/database.php';

//include Models
include_once './app/models/BaseModel.php';
include_once './app/models/Pengguna.php';
include_once './app/models/Pelanggan.php';
include_once './app/models/Kategori.php';
include_once './app/models/Produk.php';
include_once './app/models/Keranjang.php';
include_once './app/models/DetailKeranjang.php';
include_once './app/models/Pesanan.php';
include_once './app/models/DetailPesanan.php';
include_once './app/models/Pembayaran.php';


//include Controllers
include_once './app/controllers/AuthController.php';
include_once './app/controllers/HomeController.php';
include_once './app/controllers/DashboardController.php';
include_once './app/controllers/PelangganController.php';
include_once './app/controllers/KeranjangController.php';
include_once './app/controllers/DetailKeranjangController.php';
include_once './app/controllers/PesananController.php';
include_once './app/controllers/KategoriController.php';
include_once './app/controllers/ProdukController.php';
include_once './app/controllers/PenggunaController.php';
include_once './app/controllers/PembayaranController.php';


//jika local development, silahkan ubah nilai variabel nama_project
$app_name = 'WFC';

//jika sudah diupload di hosting silahkan ubah berikut
$url = 'https://wolsfriedchicken.infinityfreeapp.com/';

$logo = getBaseUrl()."./assets/images/logowfc.jpg";

function getBaseUrl() {
    global $app_name, $url; 
    
    if ($_SERVER['SERVER_NAME'] === 'localhost') {
        return "http://localhost/{$app_name}/"; 
    } else {
        return $url;
    }
}
