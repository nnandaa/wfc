<?php
class AuthController
{
    private $pengguna;
    private $pelanggan;

    public function __construct()
    {
        $this->pengguna = new Pengguna();
        $this->pelanggan = new Pelanggan();
    }

    private function validateRegister(array $data): array
    {
        $errors = [];

        if (empty($data['username'])) {
            $errors['username'] = "username is required.";
        }

        if (empty($data['password']) || strlen($data['password']) < 8) {
            $errors['password'] = "Password must be at least 8 characters 
long.";
        }

        if (empty($data['email']) || !filter_var(
            $data['email'],
            FILTER_VALIDATE_EMAIL
        )) {
            $errors['email'] = "Please enter a valid email address.";
        }

        if (empty($data['nama'])) {
            $errors['nama'] = "username is required.";
        }

        if (empty($data['telp'])) {
            $errors['telp'] = "No. Telp is required.";
        }

        if (empty($data['alamat'])) {
            $errors['alamat'] = "Alamat is required.";
        }

        if (!empty($this->pengguna->search('username', $data['username']))) {
            $errors['username'] = "Username is allready taken";
        }

        if (!empty($this->pengguna->search('email', $data['email']))) {
            $errors['email'] = "Email is allready taken";
        }

        return $errors;
    }

    public function save_pelanggan($data)
    {
        $pelangganData = [
            'nama' => $data['nama'],
            'alamat' => $data['alamat'],
            'telp' => $data['telp']
        ];

        return $this->pengguna->savePelanggan($pelangganData);
    }

    public function daftar($data): array
    {
        $errors = $this->validateRegister($data);

        if (!empty($errors)) {
            return $errors;
        }

        $pelangganId = $this->save_pelanggan($data);

        if ($pelangganId) {
            $data['id_pelanggan'] = $pelangganId;

            $success = $this->pengguna->save($data);

            if (!$success) {
                $this->pelanggan->delete($pelangganId);
            }
        } else {
            $success = false;
        }

        return $success
            ? ['icon' => 'success', 'message' => 'Registrasi Berhasil']
            : ['icon' => 'error', 'message' => 'Terjadi kesalahan Registrasi 
member baru'];
    }

    public function masuk($email, $password): array
    {
        $result = $this->pengguna->login($email, $password);
        return !empty($result) ? ['icon' => 'success', 'message' => 'Berhasil 
Login', 'user' => $result]
            : ['icon' => 'error', 'message' => 'Username dan Password tidak 
ditemukan'];
    }

    public function keluar()
    {
        session_destroy();
    }
}
