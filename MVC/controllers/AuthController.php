<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../repositories/reUser.php';
class AuthController {
    private $users;
    public function __construct() {
        $this->users = new reUser((new Database())->connect());
    }
    public function captchaImage() {
        $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $code = '';
        for ($i = 0; $i < 5; $i++) $code .= $alphabet[random_int(0, strlen($alphabet) - 1)];
        $_SESSION['text_captcha_answer'] = $code;
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="170" height="54" viewBox="0 0 170 54">';
        $svg .= '<rect width="170" height="54" rx="9" fill="#fbf7f0"/>';
        $svg .= '<circle cx="18" cy="12" r="11" fill="#a9b78f" fill-opacity=".1"/><circle cx="154" cy="44" r="15" fill="#b79774" fill-opacity=".08"/>';
        $noise = ['#a88d70', '#8b7058', '#788167', '#c0a788'];
        $letterColors = ['#6b4a36', '#556245', '#8b5e47', '#4b392d', '#78634f'];
        for ($i = 0; $i < 7; $i++) {
            $x1 = random_int(0, 170); $y1 = random_int(0, 54);
            $x2 = random_int(0, 170); $y2 = random_int(0, 54);
            $svg .= '<path d="M' . $x1 . ' ' . $y1 . ' L' . $x2 . ' ' . $y2 . '" stroke="' . $noise[$i % count($noise)] . '" stroke-opacity=".28" stroke-width="1"/>';
        }
        for ($i = 0; $i < strlen($code); $i++) {
            $x = 19 + $i * 30; $y = random_int(34, 41); $angle = random_int(-11, 11);
            $svg .= '<text x="' . $x . '" y="' . $y . '" transform="rotate(' . $angle . ' ' . $x . ' ' . $y . ')" font-family="Georgia,serif" font-size="26" font-weight="700" fill="' . $letterColors[$i] . '">' . $code[$i] . '</text>';
        }
        $svg .= '<path d="M7 31 Q48 23 84 32 T163 28" fill="none" stroke="#8b7058" stroke-opacity=".38" stroke-width="1.5"/>';
        $svg .= '</svg>';
        header('Content-Type: image/svg+xml; charset=UTF-8');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        echo $svg;
        exit;
    }
    public function login() {
        if (currentUser()) {
            header('Location: ' . url('Home'), true, 303);
            exit;
        }
        $errors = [];
        $username = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rawUsername = $_POST['tenDangNhap'] ?? '';
            $password = $_POST['matKhau'] ?? '';
            $captchaOk = verifyTextCaptcha($_POST['captcha'] ?? null);
            $username = is_string($rawUsername) ? trim($rawUsername) : '';
            if (!$captchaOk) $errors[] = 'Mã xác minh chưa đúng.';
            if ($username === '' || !is_string($password) || $password === '') {
                $errors[] = 'Vui lòng nhập tên đăng nhập và mật khẩu.';
            } elseif ($captchaOk) {
                $user = $this->users->findByUsername($username);
                if ($user && password_verify($password, $user['matKhau'])) {
                    session_regenerate_id(true);
                    $_SESSION['csrf'] = bin2hex(random_bytes(24));
                    $_SESSION['user'] = [
                        'maNguoiDung' => (int)$user['maNguoiDung'],
                        'tenDangNhap' => $user['tenDangNhap'],
                        'hoTen' => $user['hoTen'],
                        'email' => $user['email'] ?? '',
                        'soDienThoai' => $user['soDienThoai'] ?? '',
                        'vaiTro' => $user['vaiTro']
                    ];
                    header('Location: ' . url('Home'), true, 303);
                    exit;
                }
                $errors[] = 'Tên đăng nhập hoặc mật khẩu không đúng.';
            }
        }
        $pageTitle = 'Log in';
        require __DIR__ . '/../views/auth/login.php';
    }
    public function register() {
        if (currentUser()) {
            header('Location: ' . url('Home'), true, 303);
            exit;
        }
        $errors = [];
        $username = '';
        $email = '';
        $phone = '';
        $fullName = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rawUsername = $_POST['tenDangNhap'] ?? '';
            $rawName = $_POST['hoTen'] ?? '';
            $rawEmail = $_POST['email'] ?? '';
            $rawPhone = $_POST['soDienThoai'] ?? '';
            $password = $_POST['matKhau'] ?? '';
            $confirm = $_POST['xacNhanMatKhau'] ?? '';
            $username = is_string($rawUsername) ? trim($rawUsername) : '';
            $fullName = is_string($rawName) ? trim($rawName) : '';
            $email = is_string($rawEmail) ? strtolower(trim($rawEmail)) : '';
            $phone = is_string($rawPhone) ? trim($rawPhone) : '';
            $captchaOk = verifyTextCaptcha($_POST['captcha'] ?? null);

            if (!$captchaOk) $errors[] = 'Mã xác minh chưa đúng.';
            if (!preg_match('/^[A-Za-z0-9_.-]{3,50}$/', $username)) $errors[] = 'Tên đăng nhập cần từ 3–50 ký tự, chỉ gồm chữ không dấu, số, dấu chấm, gạch dưới hoặc gạch ngang.';
            if ($fullName === '' || mb_strlen($fullName, 'UTF-8') > 100) $errors[] = 'Vui lòng nhập họ tên, tối đa 100 ký tự.';
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) $errors[] = 'Vui lòng nhập địa chỉ email hợp lệ.';
            $normalizedPhone = preg_replace('/[ .-]/', '', $phone);
            if (!preg_match('/^(?:\\+?84|0)[0-9]{9,10}$/', $normalizedPhone)) $errors[] = 'Vui lòng nhập số điện thoại Việt Nam hợp lệ.';
            if (!is_string($password) || strlen($password) < 8 || strlen($password) > 200) $errors[] = 'Mật khẩu cần dài từ 8 đến 200 ký tự.';
            if (!is_string($confirm) || !is_string($password) || !hash_equals($password, $confirm)) $errors[] = 'Hai lần nhập mật khẩu chưa khớp.';
            if (!$errors && $this->users->findByUsername($username)) $errors[] = 'Tên đăng nhập này đã được sử dụng.';
            if (!$errors && $this->users->findByEmail($email)) $errors[] = 'Email này đã được dùng cho tài khoản khác.';

            if (!$errors) {
                $newUser = new User(null, $username, password_hash($password, PASSWORD_DEFAULT), $fullName, 'customer', $email, $normalizedPhone);
                try {
                    $this->users->create($newUser);
                    header('Location: ' . url('Auth', 'login', ['registered' => '1']), true, 303);
                    exit;
                } catch (PDOException $e) {
                    if ($e->getCode() === '23000') $errors[] = 'Tên đăng nhập hoặc email này đã được sử dụng.';
                    else throw $e;
                }
            }
        }
        $pageTitle = 'Register';
        require __DIR__ . '/../views/auth/register.php';
    }
    public function forgotPassword() {
        $errors = [];
        $sent = false;
        $email = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rawEmail = $_POST['email'] ?? '';
            $email = is_string($rawEmail) ? strtolower(trim($rawEmail)) : '';
            $captchaOk = verifyTextCaptcha($_POST['captcha'] ?? null);
            if (!$captchaOk) $errors[] = 'Mã xác minh chưa đúng.';
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) $errors[] = 'Vui lòng nhập địa chỉ email hợp lệ.';
            if (!$errors) {
                $user = $this->users->findByEmail($email);
                if ($user) {
                    $token = bin2hex(random_bytes(32));
                    $hash = hash('sha256', $token);
                    $expiresAt = date('Y-m-d H:i:s', time() + 3600);
                    $this->users->addPasswordResetToken((int)$user['maNguoiDung'], $hash, $expiresAt);
                    $link = $this->absoluteUrl(url('Auth', 'resetPassword', ['token' => $token]));
                    $this->sendPasswordResetEmail($email, $link);
                }
                // Keep the response the same whether this email belongs to an account or not.
                $sent = true;
                $email = '';
            }
        }
        $pageTitle = 'Forgot password';
        require __DIR__ . '/../views/auth/forgot_password.php';
    }
    public function resetPassword() {
        $token = $_GET['token'] ?? '';
        if (!is_string($token) || !preg_match('/^[a-f0-9]{64}$/', $token)) $token = '';
        $tokenHash = $token === '' ? '' : hash('sha256', $token);
        $valid = $tokenHash !== '' && $this->users->findValidPasswordReset($tokenHash);
        $errors = [];
        $complete = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postToken = $_POST['token'] ?? '';
            $password = $_POST['matKhau'] ?? '';
            $confirm = $_POST['xacNhanMatKhau'] ?? '';
            $postHash = is_string($postToken) && preg_match('/^[a-f0-9]{64}$/', $postToken) ? hash('sha256', $postToken) : '';
            if (!is_string($password) || strlen($password) < 8 || strlen($password) > 200) $errors[] = 'Mật khẩu cần dài từ 8 đến 200 ký tự.';
            if (!is_string($confirm) || !is_string($password) || !hash_equals($password, $confirm)) $errors[] = 'Hai lần nhập mật khẩu chưa khớp.';
            if (!$postHash || !$this->users->findValidPasswordReset($postHash)) $errors[] = 'Link đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.';
            if (!$errors) {
                $complete = $this->users->completePasswordReset($postHash, password_hash($password, PASSWORD_DEFAULT));
                if (!$complete) $errors[] = 'Link đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.';
            }
            $valid = !$complete && $postHash !== '' && (bool)$this->users->findValidPasswordReset($postHash);
        }
        $pageTitle = 'Reset password';
        require __DIR__ . '/../views/auth/reset_password.php';
    }
    private function absoluteUrl($relativePath) {
        $host = $_SERVER['HTTP_HOST'] ?? '';
        if (!preg_match('/^[a-zA-Z0-9.-]+(?::[0-9]{1,5})?$/', $host)) return $relativePath;
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/index.php'));
        if ($scriptDir === '/' || $scriptDir === '.') $scriptDir = '';
        return $scheme . '://' . $host . $scriptDir . '/' . ltrim($relativePath, '/');
    }
    private function sendPasswordResetEmail($email, $link) {
        $config = require __DIR__ . '/../config/mail.php';
        $from = $config['from'] ?? '';
        if (!filter_var($from, FILTER_VALIDATE_EMAIL)) return false;
        $subject = '=?UTF-8?B?' . base64_encode('Đặt lại mật khẩu Nâu Coffee') . '?=';
        $body = "Xin chào,\r\n\r\nBạn vừa yêu cầu đặt lại mật khẩu Nâu Coffee. Mở link sau trong vòng 60 phút:\r\n" . $link . "\r\n\r\nNếu bạn không yêu cầu, hãy bỏ qua email này.\r\n";
        $headers = 'From: Nâu Coffee <' . $from . ">\r\n" . 'Content-Type: text/plain; charset=UTF-8';
        $sent = mail($email, $subject, $body, $headers);
        if (!$sent) error_log('Nau Coffee password reset email could not be sent. Check PHP mail/SMTP configuration.');
        return $sent;
    }
    public function logout() {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
        header('Location: ' . url('Home'), true, 303);
        exit;
    }
}
