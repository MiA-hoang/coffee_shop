<?php require __DIR__ . '/../layout/header.php'; ?>
<section class="account-page" aria-labelledby="account-title">
  <div class="account-heading">
    <p class="eyebrow">Góc nhỏ của bạn</p>
    <h1 id="account-title">Tài khoản của tôi</h1>
    <p class="login-subtitle">Quản lý thông tin liên hệ và xem lại những đơn hàng đã đặt.</p>
  </div>

  <div class="account-grid">
    <section class="account-panel" id="ho-so" aria-labelledby="profile-title">
      <p class="eyebrow">Thông tin cá nhân</p>
      <h2 id="profile-title">Hồ sơ của bạn</h2>
      <?php if ($saved): ?><p class="notice">Thông tin tài khoản đã được cập nhật.</p><?php endif; ?>
      <?php if ($errors): ?><div class="login-error" role="alert"><?php foreach ($errors as $error): ?><p><?= h($error) ?></p><?php endforeach; ?></div><?php endif; ?>
      <form method="post" action="<?= h(url('Account', 'index')) ?>" class="login-form">
        <?= csrfField() ?>
        <div class="login-field"><label for="account-name">Họ và tên</label><input id="account-name" value="<?= h($profile['hoTen']) ?>" disabled></div>
        <div class="login-field"><label for="account-username">Tên đăng nhập</label><input id="account-username" value="<?= h($profile['tenDangNhap']) ?>" disabled></div>
        <div class="login-field"><label for="account-email">Email</label><input id="account-email" name="email" type="email" maxlength="255" autocomplete="email" required value="<?= h($profile['email'] ?? '') ?>"></div>
        <div class="login-field"><label for="account-phone">Số điện thoại</label><input id="account-phone" name="soDienThoai" type="tel" maxlength="20" autocomplete="tel" inputmode="tel" required value="<?= h($profile['soDienThoai'] ?? '') ?>"></div>
        <button type="submit" class="login-submit">Lưu thay đổi <span aria-hidden="true">→</span></button>
      </form>
    </section>

    <section class="account-panel" aria-labelledby="history-title">
      <p class="eyebrow">Những lần bạn chọn Nâu</p>
      <h2 id="history-title">Lịch sử mua hàng</h2>
      <?php if (!$orders): ?>
        <div class="account-empty"><span aria-hidden="true">☕</span><p>Bạn chưa có đơn hàng nào gắn với tài khoản này.</p><a class="btn btn-ghost" href="<?= h(url('Product', 'index')) ?>">Khám phá thực đơn</a></div>
      <?php else: ?>
        <div class="account-orders">
          <?php foreach ($orders as $order): ?>
            <article class="account-order">
              <div class="account-order-top"><strong>Đơn #<?= h($order['maDonHang']) ?></strong><time><?= h(date('d/m/Y H:i', strtotime($order['ngayDat']))) ?></time></div>
              <p><?= h($order['sanPham'] ?: 'Chưa có sản phẩm') ?></p>
              <strong><?= h(formatPrice($order['tongTien'])) ?></strong>
            </article>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </section>
  </div>
</section>
<?php require __DIR__ . '/../layout/footer.php'; ?>
