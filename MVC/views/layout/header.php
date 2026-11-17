<?php
// Đặt $pageTitle trong controller trước khi include file này.
// Đặt $fullWidth = true trước khi include để trang dùng toàn chiều rộng (trang chủ).
$currentController = isset($_GET['controller']) && is_string($_GET['controller']) ? $_GET['controller'] : 'Home';
$nav = ['Home' => 'Trang chủ', 'Product' => 'Thực đơn', 'Category' => 'Danh mục', 'Cart' => 'Giỏ hàng', 'Auth' => 'Đăng nhập'];
$fullWidth = $fullWidth ?? false;
?><!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= h(($pageTitle ?? 'Nâu Coffee') . ' – ' . SITE_NAME) ?></title>
<meta name="description" content="Nâu Coffee – quán cà phê rang xay thủ công, không gian yên tĩnh để chậm lại giữa ngày dài.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600&family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header">
  <div class="container header-inner">
    <a class="logo" href="<?= h(url('Home')) ?>" aria-label="<?= h(SITE_NAME) ?> – trang chủ">
      <svg viewBox="0 0 32 32" aria-hidden="true"><ellipse cx="16" cy="16" rx="9" ry="13" transform="rotate(35 16 16)" fill="currentColor"/><path d="M9 8c6 4 8 10 14 16" stroke="#fbf7f0" stroke-width="2" fill="none" stroke-linecap="round"/></svg>
      <?= h(SITE_NAME) ?>
    </a>

    <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav" aria-label="Mở menu">
      <span></span><span></span><span></span>
    </button>

    <nav class="site-nav" id="site-nav" aria-label="Menu chính">
      <?php foreach ($nav as $controller => $label): ?>
        <a href="<?= h(url($controller, $controller === 'Auth' ? 'login' : 'index')) ?>"<?= $currentController === $controller ? ' aria-current="page"' : '' ?>><?= h($label) ?></a>
      <?php endforeach; ?>
      <a class="nav-cta" href="<?= h(url('Home')) ?>#lien-he">Ghé quán</a>
    </nav>
  </div>
</header>
<main>
<?php if (!$fullWidth): ?><div class="container page"><?php endif; ?>
