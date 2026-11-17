<?php require __DIR__ . '/../layout/header.php'; ?>
<h1>Thực đơn</h1>
<form method="get" class="filter">
  <input type="hidden" name="controller" value="Product">
  <input type="hidden" name="action" value="index">
  <input type="search" name="q" placeholder="Tìm theo tên món" value="<?= h($q) ?>" aria-label="Tìm theo tên món">
  <select name="maDanhMuc" aria-label="Danh mục">
    <option value="">Tất cả danh mục</option>
    <?php foreach ($categories as $category): ?>
      <option value="<?= (int)$category['maDanhMuc'] ?>" <?= (string)$categoryId === (string)$category['maDanhMuc'] ? 'selected' : '' ?>><?= h($category['tenDanhMuc']) ?></option>
    <?php endforeach; ?>
  </select>
  <button>Lọc</button>
</form>
<?php if (!$items): ?>
  <p class="empty">Không có món phù hợp. Hãy thử từ khóa khác hoặc <a href="<?= h(url('Product', 'create')) ?>">thêm món mới</a>.</p>
<?php else: ?>
  <ul class="menu">
    <?php foreach ($items as $item) { require __DIR__ . '/_item.php'; } ?>
  </ul>
<?php endif; ?>
<?php require __DIR__ . '/../layout/footer.php'; ?>
