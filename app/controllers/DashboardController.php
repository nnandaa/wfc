<?php 
class DashboardController 
{ 
    private $queryUrl; 
    private $menu; 
    private $sub; 
    private $aksi; 
    private $isValid; 
 
    const VALID_MENU = [ 
        'home' => ['overview'], 
        'shop' => ['produk', 'kategori', 'pelanggan'], 
        'transaksi' => ['keranjang', 'pesanan'], 
        'laporan' => ['produk', 'penjualan'], 
        'pengaturan' => ['pengguna'], 
    ]; 
 
    const VALID_AKSI = [ 
        'produk' => ['tambah', 'edit', 'index'], 
        'kategori' => ['tambah', 'edit', 'index'], 
        'keranjang' => ['tambah', 'edit', 'index'], 
        'pelanggan' => ['tambah', 'edit', 'index'], 
        'pesanan' => ['tambah', 'edit', 'index'], 
        'pengguna' => ['tambah', 'edit', 'index'], 
        'laporan' => ['produk', 'penjualan'], 
    ];
 
    const DEFAULT_MENU = 'shop'; 
    const DEFAULT_AKSI = 'index'; 
 
    public function __construct($queryUrl) 
    { 
        $this->queryUrl = $queryUrl ?? ''; 
        $this->parseQueryUri(); 
        $this->validateUri(); 
    } 
 
    private function parseQueryUri() 
    { 
        parse_str($this->queryUrl, $parameters); 
        $this->menu = $parameters['menu'] ?? self::DEFAULT_MENU; 
        $this->sub = $parameters['sub'] ?? ''; 
        $this->aksi = $parameters['aksi'] ?? self::DEFAULT_AKSI; 
    } 
 
    private function validateUri() 
    { 
        $this->isValid = $this->isValidMenu() && $this->isValidSub() && $this->isValidAksi(); 
    } 
 
    private function isValidMenu() 
    { 
        return isset(self::VALID_MENU[$this->menu]); 
    } 
 
    private function isValidSub() 
    { 
        return isset(self::VALID_MENU[$this->menu]) && in_array($this->sub, 
self::VALID_MENU[$this->menu], true); 
    } 
 
    private function isValidAksi() 
    { 
        return isset(self::VALID_AKSI[$this->sub]) && in_array($this->aksi, 
self::VALID_AKSI[$this->sub], true); 
    } 
 
    public function getContentPath() 
    { 
        if (!$this->isValid) { 
            return false; 
        } 
 
        return realpath('./' . $this->menu . '/' . $this->sub . '/' . $this->aksi . '.php') ?: false; 
    } 
 
    public function getMenuName() 
    { 
        return $this->menu; 
    } 
 
    public function getSubName() 
    { 
        return $this->sub; 
    } 
 
    public function getAksiName() 
    { 
        return $this->aksi; 
    } 
 
    public function getQueryURL() 
    { 
        return $this->queryUrl; 
    } 
} 
