<?php
require_once __DIR__ . '/interface.php';
require_once __DIR__ . '/../models/Product.php';
class reProduct implements RepositoryInterface {
    private $conn;
    public function __construct($db) { $this->conn = $db; }
    public function getAll($q = '', $categoryId = null) {
        $sql = 'SELECT p.maSanPham, p.tenSanPham, p.gia, p.moTa, p.hinhAnh, p.maDanhMuc, c.tenDanhMuc
                FROM tblSanPham p
                INNER JOIN tblDanhMuc c ON c.maDanhMuc = p.maDanhMuc';
        $conditions = [];
        $params = [];
        if ($q !== '') {
            // Search the name only; escape \, % and _ so they match literally.
            $conditions[] = 'p.tenSanPham LIKE :q';
            $params['q'] = '%' . str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $q) . '%';
        }
        if ($categoryId !== null) {
            $conditions[] = 'p.maDanhMuc = :maDanhMuc';
            $params['maDanhMuc'] = $categoryId;
        }
        if ($conditions) $sql .= ' WHERE ' . implode(' AND ', $conditions);
        $sql .= ' ORDER BY c.maDanhMuc, p.tenSanPham';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    public function getFeatured($limit = 4) {
        $sql = 'SELECT p.maSanPham, p.tenSanPham, p.gia, p.moTa, p.hinhAnh, p.maDanhMuc, c.tenDanhMuc
                FROM tblSanPham p INNER JOIN tblDanhMuc c ON c.maDanhMuc = p.maDanhMuc
                ORDER BY (p.hinhAnh IS NULL), p.maSanPham DESC LIMIT ' . (int)$limit;
        return $this->conn->query($sql)->fetchAll();
    }
    // One product as an array, including its category name (used by the detail page).
    public function getDetail($id) {
        $stmt = $this->conn->prepare('SELECT p.*, c.tenDanhMuc FROM tblSanPham p
                                      INNER JOIN tblDanhMuc c ON c.maDanhMuc = p.maDanhMuc
                                      WHERE p.maSanPham = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }
    public function create($object) {
        $stmt = $this->conn->prepare('INSERT INTO tblSanPham (tenSanPham, gia, moTa, hinhAnh, maDanhMuc)
                                      VALUES (:ten, :gia, :moTa, :hinhAnh, :maDanhMuc)');
        return $stmt->execute([
            'ten' => $object->getTenSanPham(),
            'gia' => $object->getGia(),
            'moTa' => $object->getMoTa(),
            'hinhAnh' => $object->getHinhAnh(),
            'maDanhMuc' => $object->getMaDanhMuc()
        ]);
    }
    public function getById($id) {
        $stmt = $this->conn->prepare('SELECT * FROM tblSanPham WHERE maSanPham = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        if (!$row) return null;
        return new Product($row['maSanPham'], $row['tenSanPham'], $row['gia'], $row['moTa'], $row['hinhAnh'], $row['maDanhMuc']);
    }
    // Statistics per category (LEFT JOIN keeps empty categories).
    public function summary() {
        $sql = 'SELECT c.tenDanhMuc,
                       COUNT(p.maSanPham) AS soSanPham,
                       COALESCE(ROUND(AVG(p.gia)), 0) AS giaTrungBinh,
                       COALESCE(MAX(p.gia), 0) AS giaCaoNhat
                FROM tblDanhMuc c
                LEFT JOIN tblSanPham p ON p.maDanhMuc = c.maDanhMuc
                GROUP BY c.maDanhMuc, c.tenDanhMuc
                ORDER BY c.maDanhMuc';
        return $this->conn->query($sql)->fetchAll();
    }
    // Kept to satisfy the interface; not part of this starter.
    public function update($object) { throw new BadMethodCallException('Edit is not implemented.'); }
    public function delete($id) { throw new BadMethodCallException('Delete is not implemented.'); }
}
