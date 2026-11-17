<?php
class reCategory {
    private $conn;
    public function __construct($db) { $this->conn = $db; }
    public function getAll() {
        return $this->conn->query('SELECT * FROM tblDanhMuc ORDER BY maDanhMuc')->fetchAll();
    }
    public function exists($id) {
        $stmt = $this->conn->prepare('SELECT 1 FROM tblDanhMuc WHERE maDanhMuc = :id');
        $stmt->execute(['id' => $id]);
        return (bool)$stmt->fetchColumn();
    }
    // Every category with its number of products (0 for empty ones).
    public function getAllWithCount() {
        $sql = 'SELECT c.maDanhMuc, c.tenDanhMuc, COUNT(p.maSanPham) AS soSanPham
                FROM tblDanhMuc c
                LEFT JOIN tblSanPham p ON p.maDanhMuc = c.maDanhMuc
                GROUP BY c.maDanhMuc, c.tenDanhMuc
                ORDER BY c.maDanhMuc';
        return $this->conn->query($sql)->fetchAll();
    }
}
