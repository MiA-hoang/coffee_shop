<?php
// TODO: add getters when Auth is implemented.
class User {
    public $maNguoiDung, $tenDangNhap, $matKhau, $hoTen, $vaiTro;
    public function __construct($maNguoiDung, $tenDangNhap, $matKhau, $hoTen, $vaiTro = 'customer') {
        $this->maNguoiDung = $maNguoiDung; $this->tenDangNhap = $tenDangNhap;
        $this->matKhau = $matKhau; $this->hoTen = $hoTen; $this->vaiTro = $vaiTro;
    }
}
