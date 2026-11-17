<?php require __DIR__ . '/../layout/header.php'; ?>
<h1>Add product</h1>
<?php if ($errors): ?>
  <div class="errors" role="alert">
    <?php foreach ($errors as $error): ?><p><?= h($error) ?></p><?php endforeach; ?>
  </div>
<?php endif; ?>
<form method="post" action="<?= h(url('Product', 'store')) ?>">
  <?= csrfField() ?>
  <div class="field"><label for="tenSanPham">Name</label>
    <input id="tenSanPham" name="tenSanPham" maxlength="150" value="<?= h($values['tenSanPham'] ?? '') ?>" required></div>
  <div class="field"><label for="gia">Price (₫)</label>
    <input id="gia" name="gia" type="number" min="1" max="10000000" step="1" value="<?= h($values['gia'] ?? '') ?>" required></div>
  <div class="field"><label for="maDanhMuc">Category</label>
    <select id="maDanhMuc" name="maDanhMuc" required>
      <option value="">Choose a category</option>
      <?php foreach ($categories as $category): ?>
        <option value="<?= (int)$category['maDanhMuc'] ?>" <?= (string)($values['maDanhMuc'] ?? '') === (string)$category['maDanhMuc'] ? 'selected' : '' ?>><?= h($category['tenDanhMuc']) ?></option>
      <?php endforeach; ?>
    </select></div>
  <div class="field"><label for="moTa">Description (optional)</label>
    <textarea id="moTa" name="moTa" rows="3" maxlength="500"><?= h($values['moTa'] ?? '') ?></textarea></div>
  <button>Save product</button>
</form>
<?php require __DIR__ . '/../layout/footer.php'; ?>
