<?php
// User data model shared by authentication and the user repository.
class User {
    public $maNguoiDung, $tenDangNhap, $email, $soDienThoai, $matKhau, $hoTen, $vaiTro;
    public function __construct($maNguoiDung, $tenDangNhap, $matKhau, $hoTen, $vaiTro = 'customer', $email = null, $soDienThoai = null) {
        $this->maNguoiDung = $maNguoiDung; $this->tenDangNhap = $tenDangNhap;
        $this->email = $email; $this->soDienThoai = $soDienThoai; $this->matKhau = $matKhau; $this->hoTen = $hoTen; $this->vaiTro = $vaiTro;
    }
}
