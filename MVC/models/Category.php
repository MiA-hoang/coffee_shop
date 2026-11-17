<?php
class Category {
    public $maDanhMuc;
    public $tenDanhMuc;
    public function __construct($maDanhMuc, $tenDanhMuc) {
        $this->maDanhMuc = $maDanhMuc;
        $this->tenDanhMuc = $tenDanhMuc;
    }
    public function getMaDanhMuc() { return $this->maDanhMuc; }
    public function getTenDanhMuc() { return $this->tenDanhMuc; }
}
