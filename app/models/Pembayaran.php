<?php

class Pembayaran extends BaseModel
{
    // Nama tabel di database
    protected $table = 'pembayaran';

    // Kolom yang bisa diisi
    protected $fillable = ['alamat', 'metode_pembayaran', 'foto_bukti_transfer'];

    public function __construct()
    {
        parent::__construct();
    }

    public function save(array $data): bool
    {
        return parent::save($data);
    }

    // Fungsi untuk mengambil semua data pembayaran
    public function selectAll(): array
    {
        $query = "SELECT * FROM $this->table ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
