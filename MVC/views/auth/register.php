<?php require __DIR__ . '/../layout/header.php'; ?>
<section class="login-wrap" aria-labelledby="register-title">
  <div class="register-card">
    <a class="register-brand" href="<?= h(url('Home')) ?>">
      <span class="login-logo-mark" aria-hidden="true">
        <svg viewBox="0 0 64 64"><ellipse cx="32" cy="32" rx="17" ry="25" transform="rotate(35 32 32)" fill="currentColor"/><path d="M20 17c12 8 16 20 28 30" stroke="#fbf7f0" stroke-width="3" fill="none" stroke-linecap="round"/></svg>
      </span>
      <span>Nâu Coffee</span>
    </a>
    <div class="login-heading">
      <p class="eyebrow">Tài khoản khách hàng</p>
      <h1 id="register-title">Đăng ký</h1>
      <p class="login-subtitle">Tạo tài khoản để đặt hàng và theo dõi những ly cà phê bạn yêu thích.</p>
    </div>
    <?php if ($errors): ?>
      <div class="login-error" role="alert"><strong>Vui lòng kiểm tra lại</strong><?php foreach ($errors as $error): ?><p><?= h($error) ?></p><?php endforeach; ?></div>
    <?php endif; ?>
    <form method="post" action="<?= h(url('Auth', 'register')) ?>" class="login-form">
      <?= csrfField() ?>
      <div class="login-field">
        <label for="hoTen">Họ và tên</label>
        <input id="hoTen" name="hoTen" type="text" maxlength="100" autocomplete="name" placeholder="Nhập họ tên" required value="<?= h($fullName) ?>">
      </div>
      <div class="login-field">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" maxlength="255" autocomplete="email" placeholder="ban@example.com" required value="<?= h($email) ?>">
      </div>
      <div class="login-field">
        <label for="soDienThoai">Số điện thoại</label>
        <input id="soDienThoai" name="soDienThoai" type="tel" maxlength="20" autocomplete="tel" inputmode="tel" placeholder="0912 345 678" required value="<?= h($phone) ?>">
      </div>
      <div class="login-field">
        <label for="tenDangNhap">Tên đăng nhập</label>
        <input id="tenDangNhap" name="tenDangNhap" type="text" minlength="3" maxlength="50" autocomplete="username" placeholder="3–50 ký tự, không dấu" required value="<?= h($username) ?>">
      </div>
      <div class="login-field">
        <label for="matKhau">Mật khẩu</label>
        <input id="matKhau" name="matKhau" type="password" minlength="8" maxlength="200" autocomplete="new-password" placeholder="Ít nhất 8 ký tự" required>
      </div>
      <div class="login-field">
        <label for="xacNhanMatKhau">Nhập lại mật khẩu</label>
        <input id="xacNhanMatKhau" name="xacNhanMatKhau" type="password" minlength="8" maxlength="200" autocomplete="new-password" placeholder="Nhập lại mật khẩu" required>
      </div>
      <div class="login-field">
        <label for="captcha">Nhập mã trong ảnh</label>
        <?= captchaWidget() ?>
        <input id="captcha" name="captcha" type="text" maxlength="5" autocapitalize="characters" autocomplete="off" spellcheck="false" placeholder="Gõ lại 5 ký tự" required>
      </div>
      <button type="submit" class="login-submit">Tạo tài khoản <span aria-hidden="true">→</span></button>
    </form>
    <p class="auth-links"><span>Đã có tài khoản?</span> <a href="<?= h(url('Auth', 'login')) ?>">Đăng nhập</a></p>
  </div>
</section>
<?php require __DIR__ . '/../layout/footer.php'; ?>
