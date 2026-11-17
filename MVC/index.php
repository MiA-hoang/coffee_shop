<?php
require_once __DIR__ . '/config/helpers.php';
// Whitelist of controller => actions. Anything else is a 404.
$routes = [
    'Home'     => ['index'],
    'Product'  => ['index', 'detail', 'create', 'store', 'report'],
    'Category' => ['index'],
    'Cart'     => ['index'],   // TODO stub
    'Order'    => ['index', 'checkout'], // TODO stub
    'Auth'     => ['login'],   // TODO stub
];
$controllerName = $_GET['controller'] ?? 'Home';
$action = $_GET['action'] ?? 'index';
if (!is_string($controllerName) || !is_string($action) || !isset($routes[$controllerName]) || !in_array($action, $routes[$controllerName], true)) {
    http_response_code(404); exit('Page not found.');
}
$method = $action === 'store' ? 'POST' : 'GET';
if ($_SERVER['REQUEST_METHOD'] !== $method) { http_response_code(405); header('Allow: ' . $method); exit('Method not allowed.'); }
if ($method === 'POST') checkCsrf();
require_once __DIR__ . '/controllers/' . $controllerName . 'Controller.php';
$class = $controllerName . 'Controller';
(new $class())->$action();
