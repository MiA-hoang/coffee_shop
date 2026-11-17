<?php /* Expects $item (row from reProduct::getAll / getFeatured). */ ?>
<li class="menu-item">
  <div class="menu-line">
    <a class="menu-name" href="<?= h(url('Product', 'detail', ['id' => (int)$item['maSanPham']])) ?>"><?= h($item['tenSanPham']) ?></a>
    <span class="leader" aria-hidden="true"></span>
    <span class="menu-price"><?= h(formatPrice($item['gia'])) ?></span>
  </div>
  <p class="menu-desc"><?= h($item['moTa'] ?? '') ?> <span class="tag"><?= h($item['tenDanhMuc']) ?></span></p>
</li>
