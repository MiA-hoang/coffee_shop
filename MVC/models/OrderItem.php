<?php
// TODO: add getters when Order is implemented.
class OrderItem {
    public $maChiTiet, $maDonHang, $maSanPham, $soLuong, $donGia;
    public function __construct($maChiTiet, $maDonHang, $maSanPham, $soLuong, $donGia) {
        $this->maChiTiet = $maChiTiet; $this->maDonHang = $maDonHang;
        $this->maSanPham = $maSanPham; $this->soLuong = $soLuong; $this->donGia = $donGia;
    }
}
