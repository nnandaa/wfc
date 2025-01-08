<?php

class PembayaranController
{
    private $pembayaran;

    public function __construct()
    {
        $this->pembayaran = new Pembayaran();
    }

    // Fungsi untuk menyimpan pembayaran
    public function tambahPembayaran($data, $file)
    {
        // Validasi input
        $errors = $this->validasiInput($data, $file);

        if (!empty($errors)) {
            return $errors; // Jika ada error, kembalikan error
        }

        // Simpan file foto bukti transfer
        $targetDir = "./uploads/";
        $targetFile = $targetDir . basename($file["foto_bukti_transfer"]["name"]);
        move_uploaded_file($file["foto_bukti_transfer"]["tmp_name"], $targetFile);

        // Siapkan data untuk disimpan
        $dataPembayaran = [
            'alamat' => $data['alamat'],
            'metode_pembayaran' => $data['metode_pembayaran'],
            'foto_bukti_transfer' => $targetFile
        ];

        // Simpan ke database
        $success = $this->pembayaran->save($dataPembayaran);

        return $success ? true : false;
    }

    private function validasiInput($data, $file)
    {
        $errors = [];

        // Validasi alamat
        if (empty($data['alamat'])) {
            $errors['alamat'] = "Alamat wajib diisi.";
        }

        // Validasi metode pembayaran
        if (empty($data['metode_pembayaran'])) {
            $errors['metode_pembayaran'] = "Metode pembayaran wajib dipilih.";
        }

        // Validasi foto bukti transfer
        if (empty($file['foto_bukti_transfer']['name'])) {
            $errors['foto_bukti_transfer'] = "Foto bukti transfer wajib diunggah.";
        } elseif ($file['foto_bukti_transfer']['size'] > 2000000) {
            $errors['foto_bukti_transfer'] = "Ukuran file terlalu besar (maksimal 2MB).";
        }

        return $errors;
    }

    // Metode untuk mengambil semua data pembayaran
    public function semuaPembayaran(): array {
        return $this->pembayaran->selectAll();
    }

    
}
