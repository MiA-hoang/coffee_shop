<?php require __DIR__ . '/../layout/header.php'; ?>
<h1>Categories</h1>
<ul class="menu">
<?php foreach ($categories as $category): ?>
  <li class="menu-item">
    <div class="menu-line">
      <a class="menu-name" href="<?= h(url('Product', 'index', ['maDanhMuc' => (int)$category['maDanhMuc']])) ?>"><?= h($category['tenDanhMuc']) ?></a>
      <span class="leader" aria-hidden="true"></span>
      <span class="menu-price"><?= (int)$category['soSanPham'] ?> <?= (int)$category['soSanPham'] === 1 ? 'item' : 'items' ?></span>
    </div>
  </li>
<?php endforeach; ?>
</ul>
<?php require __DIR__ . '/../layout/footer.php'; ?>
