<?php
// TODO: add getters when Order is implemented.
class Order {
    public $maDonHang, $tenKhach, $soDienThoai, $ngayDat, $tongTien;
    public function __construct($maDonHang, $tenKhach, $soDienThoai, $ngayDat, $tongTien) {
        $this->maDonHang = $maDonHang; $this->tenKhach = $tenKhach;
        $this->soDienThoai = $soDienThoai; $this->ngayDat = $ngayDat; $this->tongTien = $tongTien;
    }
}
