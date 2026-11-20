<?php
if (session_status() === PHP_SESSION_NONE) {
    $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    session_set_cookie_params([
        'httponly' => true,
        'secure' => $isHttps,
        'samesite' => 'Lax'
    ]);
    session_start();
}
if (!isset($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(24));
const SITE_NAME = 'Nâu Coffee';
function h($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function url($controller, $action = 'index', $extra = []) {
    return 'index.php?' . http_build_query(array_merge(['controller' => $controller, 'action' => $action], $extra));
}
function csrfField() { return '<input type="hidden" name="csrf" value="' . h($_SESSION['csrf']) . '">'; }
function checkCsrf() {
    $token = $_POST['csrf'] ?? '';
    if (!is_string($token) || !hash_equals($_SESSION['csrf'], $token)) {
        http_response_code(403); exit('Invalid form session.');
    }
}
function captchaWidget() {
    $src = url('Auth', 'captchaImage', ['v' => bin2hex(random_bytes(5))]);
    return '<div class="captcha-widget" data-captcha-widget>' .
        '<img src="' . h($src) . '" data-base-src="' . h($src) . '" alt="Mã xác minh gồm các ký tự bị làm nhiễu">' .
        '<button type="button" class="captcha-refresh" data-captcha-refresh aria-label="Đổi mã xác minh">Đổi mã</button></div>';
}
function verifyTextCaptcha($answer) {
    $expected = $_SESSION['text_captcha_answer'] ?? null;
    unset($_SESSION['text_captcha_answer']);
    return is_string($answer) && is_string($expected) && hash_equals($expected, strtoupper(trim($answer)));
}
function currentUser() { return $_SESSION['user'] ?? null; }
function requireLogin() {
    if (!currentUser()) {
        header('Location: ' . url('Auth', 'login'), true, 303);
        exit;
    }
}
function requireRole($role) {
    requireLogin();
    if ((currentUser()['vaiTro'] ?? null) !== $role) {
        http_response_code(403);
        exit('Bạn không có quyền truy cập trang này.');
    }
}
// 45000 -> "45.000 ₫"
function formatPrice($amount) { return number_format((int)$amount, 0, ',', '.') . ' ₫'; }
// Returns the web path of a product photo, or null when the file is missing.
function productImage($file) {
    $file = basename((string)$file);
    if ($file !== '' && is_file(__DIR__ . '/../assets/images/products/' . $file)) {
        return 'assets/images/products/' . rawurlencode($file);
    }
    return null;
}
