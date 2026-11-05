<?php
$base = $base ?? rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$pageTitle = $pageTitle ?? 'Nâu Coffee';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="description" content="Nâu Coffee – quán cà phê rang xay thủ công, không gian yên tĩnh để chậm lại giữa ngày dài.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600&family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $base ?>/assets/css/style.css">
</head>
<body>

<div class="announce" role="region" aria-label="Thông báo">
    <div class="container">
        <p>Miễn phí ly cold brew thứ hai cho khách ghé quán trước 10 giờ sáng, đến hết tháng này.</p>
        <button class="announce-close" type="button" aria-label="Đóng thông báo">&times;</button>
    </div>
</div>

<header class="site-header">
    <div class="container header-inner">
        <a class="logo" href="<?= $base ?>/index.php" aria-label="Nâu Coffee – trang chủ">
            <svg viewBox="0 0 32 32" aria-hidden="true"><ellipse cx="16" cy="16" rx="9" ry="13" transform="rotate(35 16 16)" fill="currentColor"/><path d="M9 8c6 4 8 10 14 16" stroke="#fbf7f0" stroke-width="2" fill="none" stroke-linecap="round"/></svg>
            Nâu Coffee
        </a>

        <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav" aria-label="Mở menu">
            <span></span><span></span><span></span>
        </button>

        <nav class="site-nav" id="site-nav" aria-label="Menu chính">
            <a href="<?= $base ?>/index.php">Trang chủ</a>
            <a href="#thuc-don">Thực đơn</a>
            <a href="#cau-chuyen">Câu chuyện</a>
            <a href="#lien-he">Liên hệ</a>
            <a class="nav-cta" href="#lien-he">Ghé quán</a>
        </nav>
    </div>
</header>