<?php
require_once __DIR__ . '/interface.php';
require_once __DIR__ . '/../models/User.php';
class reUser implements RepositoryInterface {
    private $conn;
    public function __construct($db) { $this->conn = $db; }
    public function findByUsername($username) {
        $stmt = $this->conn->prepare('SELECT maNguoiDung, tenDangNhap, email, soDienThoai, matKhau, hoTen, vaiTro FROM tblNguoiDung WHERE tenDangNhap = :username LIMIT 1');
        $stmt->execute(['username' => $username]);
        return $stmt->fetch() ?: null;
    }
    public function findByEmail($email) {
        $stmt = $this->conn->prepare('SELECT maNguoiDung, email FROM tblNguoiDung WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch() ?: null;
    }
    public function findByEmailExceptUser($email, $userId) {
        $stmt = $this->conn->prepare('SELECT maNguoiDung FROM tblNguoiDung WHERE email = :email AND maNguoiDung <> :id LIMIT 1');
        $stmt->execute(['email' => $email, 'id' => $userId]);
        return $stmt->fetch() ?: null;
    }
    public function getProfileById($id) {
        $stmt = $this->conn->prepare('SELECT maNguoiDung, tenDangNhap, email, soDienThoai, hoTen FROM tblNguoiDung WHERE maNguoiDung = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }
    public function updateContact($id, $email, $phone) {
        $stmt = $this->conn->prepare("UPDATE tblNguoiDung SET email = :email, soDienThoai = :phone WHERE maNguoiDung = :id AND vaiTro = 'customer'");
        return $stmt->execute(['email' => $email, 'phone' => $phone, 'id' => $id]);
    }
    public function create($object) {
        $stmt = $this->conn->prepare('INSERT INTO tblNguoiDung (tenDangNhap, email, soDienThoai, matKhau, hoTen, vaiTro) VALUES (:username, :email, :phone, :password, :name, :role)');
        return $stmt->execute([
            'username' => $object->tenDangNhap,
            'email' => $object->email,
            'phone' => $object->soDienThoai,
            'password' => $object->matKhau,
            'name' => $object->hoTen,
            'role' => $object->vaiTro
        ]);
    }
    public function addPasswordResetToken($userId, $tokenHash, $expiresAt) {
        $stmt = $this->conn->prepare('DELETE FROM tblPasswordReset WHERE maNguoiDung = :id');
        $stmt->execute(['id' => $userId]);
        $stmt = $this->conn->prepare('INSERT INTO tblPasswordReset (maNguoiDung, tokenHash, expiresAt) VALUES (:id, :hash, :expiresAt)');
        return $stmt->execute(['id' => $userId, 'hash' => $tokenHash, 'expiresAt' => $expiresAt]);
    }
    public function findValidPasswordReset($tokenHash) {
        $stmt = $this->conn->prepare('SELECT r.maNguoiDung FROM tblPasswordReset r WHERE r.tokenHash = :hash AND r.usedAt IS NULL AND r.expiresAt > NOW() LIMIT 1');
        $stmt->execute(['hash' => $tokenHash]);
        return $stmt->fetch() ?: null;
    }
    public function completePasswordReset($tokenHash, $passwordHash) {
        $this->conn->beginTransaction();
        try {
            $stmt = $this->conn->prepare('SELECT maNguoiDung FROM tblPasswordReset WHERE tokenHash = :hash AND usedAt IS NULL AND expiresAt > NOW() FOR UPDATE');
            $stmt->execute(['hash' => $tokenHash]);
            $reset = $stmt->fetch();
            if (!$reset) {
                $this->conn->commit();
                return false;
            }
            $id = (int)$reset['maNguoiDung'];
            $stmt = $this->conn->prepare('UPDATE tblNguoiDung SET matKhau = :password WHERE maNguoiDung = :id');
            $stmt->execute(['password' => $passwordHash, 'id' => $id]);
            $stmt = $this->conn->prepare('DELETE FROM tblPasswordReset WHERE maNguoiDung = :id');
            $stmt->execute(['id' => $id]);
            $this->conn->commit();
            return true;
        } catch (Throwable $e) {
            if ($this->conn->inTransaction()) $this->conn->rollBack();
            throw $e;
        }
    }
    public function getById($id) {
        $stmt = $this->conn->prepare('SELECT maNguoiDung, tenDangNhap, email, soDienThoai, matKhau, hoTen, vaiTro FROM tblNguoiDung WHERE maNguoiDung = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? new User($row['maNguoiDung'], $row['tenDangNhap'], $row['matKhau'], $row['hoTen'], $row['vaiTro'], $row['email'], $row['soDienThoai']) : null;
    }
    public function update($object) { throw new BadMethodCallException('User update is not implemented.'); }
    public function delete($id) { throw new BadMethodCallException('User deletion is not implemented.'); }
}
