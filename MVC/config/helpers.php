<?php
if (session_status() === PHP_SESSION_NONE) session_start();
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
