<?php
class Product {
    public $maSanPham;
    public $tenSanPham;
    public $gia;
    public $moTa;
    public $hinhAnh;
    public $maDanhMuc;
    public function __construct($maSanPham, $tenSanPham, $gia, $moTa, $hinhAnh, $maDanhMuc) {
        $this->maSanPham = $maSanPham;
        $this->tenSanPham = $tenSanPham;
        $this->gia = $gia;
        $this->moTa = $moTa;
        $this->hinhAnh = $hinhAnh;
        $this->maDanhMuc = $maDanhMuc;
    }
    public function getMaSanPham() { return $this->maSanPham; }
    public function getTenSanPham() { return $this->tenSanPham; }
    public function getGia() { return $this->gia; }
    public function getMoTa() { return $this->moTa; }
    public function getHinhAnh() { return $this->hinhAnh; }
    public function getMaDanhMuc() { return $this->maDanhMuc; }
}
