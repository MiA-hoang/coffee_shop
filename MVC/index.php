<?php
require_once __DIR__ . '/config/helpers.php';
header('Referrer-Policy: no-referrer');
// Whitelist of controller => actions. Anything else is a 404.
$routes = [
    'Home'     => ['index' => ['GET']],
    'Product'  => ['index' => ['GET'], 'detail' => ['GET'], 'create' => ['GET'], 'store' => ['POST'], 'report' => ['GET']],
    'Category' => ['index' => ['GET']],
    'Cart'     => ['index' => ['GET']], // TODO stub
    'Order'    => ['index' => ['GET'], 'checkout' => ['GET']], // TODO stub
    'Account'  => ['index' => ['GET', 'POST']],
    'Auth'     => [
        'login' => ['GET', 'POST'], 'register' => ['GET', 'POST'],
        'forgotPassword' => ['GET', 'POST'], 'resetPassword' => ['GET', 'POST'],
        'captchaImage' => ['GET'],
        'logout' => ['POST']
    ],
];
$controllerName = $_GET['controller'] ?? 'Home';
$action = $_GET['action'] ?? 'index';
if (!is_string($controllerName) || !is_string($action) || !isset($routes[$controllerName][$action])) {
    http_response_code(404); exit('Page not found.');
}
$methods = $routes[$controllerName][$action] ?? ['GET'];
if (!in_array($_SERVER['REQUEST_METHOD'], $methods, true)) { http_response_code(405); header('Allow: ' . implode(', ', $methods)); exit('Method not allowed.'); }
if ($_SERVER['REQUEST_METHOD'] === 'POST') checkCsrf();
require_once __DIR__ . '/controllers/' . $controllerName . 'Controller.php';
$class = $controllerName . 'Controller';
(new $class())->$action();
