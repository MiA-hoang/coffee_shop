<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../repositories/reUser.php';

class AccountController {
    public function index() {
        requireLogin();
        if ((currentUser()['vaiTro'] ?? '') !== 'customer') {
            http_response_code(403);
            exit('Trang tài khoản này dành cho khách hàng.');
        }

        $db = (new Database())->connect();
        $users = new reUser($db);
        $userId = (int)currentUser()['maNguoiDung'];
        $profile = $users->getProfileById($userId);
        if (!$profile) {
            $_SESSION = [];
            session_destroy();
            header('Location: ' . url('Auth', 'login'), true, 303);
            exit;
        }

        $errors = [];
        $saved = isset($_GET['saved']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = strtolower(trim((string)($_POST['email'] ?? '')));
            $phoneInput = trim((string)($_POST['soDienThoai'] ?? ''));
            $phone = preg_replace('/[ .-]/', '', $phoneInput);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) $errors[] = 'Vui lòng nhập địa chỉ email hợp lệ.';
            if (!preg_match('/^(?:\\+?84|0)[0-9]{9,10}$/', $phone)) $errors[] = 'Vui lòng nhập số điện thoại Việt Nam hợp lệ.';
            if (!$errors && $users->findByEmailExceptUser($email, $userId)) $errors[] = 'Email này đã được dùng cho tài khoản khác.';
            if (!$errors) {
                try {
                    $users->updateContact($userId, $email, $phone);
                    $_SESSION['user']['email'] = $email;
                    $_SESSION['user']['soDienThoai'] = $phone;
                    header('Location: ' . url('Account', 'index', ['saved' => '1']) . '#ho-so', true, 303);
                    exit;
                } catch (PDOException $e) {
                    if ($e->getCode() === '23000') $errors[] = 'Email này đã được dùng cho tài khoản khác.';
                    else throw $e;
                }
            }
            $profile['email'] = $email;
            $profile['soDienThoai'] = $phoneInput;
        }

        $stmt = $db->prepare("SELECT o.maDonHang, o.ngayDat, o.tongTien, GROUP_CONCAT(CONCAT(COALESCE(p.tenSanPham, 'Sản phẩm'), ' × ', i.soLuong) ORDER BY i.maChiTiet SEPARATOR ', ') AS sanPham FROM tblDonHang o LEFT JOIN tblChiTietDonHang i ON i.maDonHang = o.maDonHang LEFT JOIN tblSanPham p ON p.maSanPham = i.maSanPham WHERE o.maNguoiDung = :id GROUP BY o.maDonHang, o.ngayDat, o.tongTien ORDER BY o.ngayDat DESC, o.maDonHang DESC");
        $stmt->execute(['id' => $userId]);
        $orders = $stmt->fetchAll();
        $pageTitle = 'Tài khoản của tôi';
        require __DIR__ . '/../views/account/index.php';
    }
}
