<?php require __DIR__ . '/../layout/header.php'; ?>
<p class="back"><a href="<?= h(url('Product', 'index', ['maDanhMuc' => (int)$item['maDanhMuc']])) ?>">← Quay lại <?= h($item['tenDanhMuc']) ?></a></p>
<article class="detail">
  <?php $img = productImage($item['hinhAnh']); ?>
  <?php if ($img): ?>
    <img class="photo" src="<?= h($img) ?>" alt="<?= h($item['tenSanPham']) ?>">
  <?php else: ?>
    <div class="photo photo-empty" role="img" aria-label="Chưa có ảnh">Chưa có ảnh</div>
  <?php endif; ?>
  <div class="detail-info">
    <p class="eyebrow"><?= h($item['tenDanhMuc']) ?></p>
    <h1><?= h($item['tenSanPham']) ?></h1>
    <p class="detail-price"><?= h(formatPrice($item['gia'])) ?></p>
    <p class="detail-desc"><?= h($item['moTa'] ?? 'Chưa có mô tả.') ?></p>
  </div>
</article>
<?php require __DIR__ . '/../layout/footer.php'; ?>
