<?php require __DIR__ . '/../layout/header.php'; ?>
<section class="login-wrap" aria-labelledby="reset-title">
  <div class="register-card">
    <a class="register-brand" href="<?= h(url('Home')) ?>">
      <span class="login-logo-mark" aria-hidden="true">
        <svg viewBox="0 0 64 64"><ellipse cx="32" cy="32" rx="17" ry="25" transform="rotate(35 32 32)" fill="currentColor"/><path d="M20 17c12 8 16 20 28 30" stroke="#fbf7f0" stroke-width="3" fill="none" stroke-linecap="round"/></svg>
      </span><span>Nâu Coffee</span>
    </a>
    <div class="login-heading">
      <p class="eyebrow">Khôi phục tài khoản</p>
      <h1 id="reset-title">Đặt mật khẩu mới</h1>
    </div>
    <?php if ($complete): ?>
      <div class="register-success" role="status">Mật khẩu đã được đổi. <a href="<?= h(url('Auth', 'login')) ?>">Đăng nhập</a></div>
    <?php elseif (!$valid && !$errors): ?>
      <div class="login-error" role="alert"><p>Link không hợp lệ hoặc đã hết hạn. Hãy yêu cầu link mới.</p></div>
      <p class="auth-links"><a href="<?= h(url('Auth', 'forgotPassword')) ?>">Yêu cầu link mới</a></p>
    <?php else: ?>
      <?php if ($errors): ?><div class="login-error" role="alert"><?php foreach ($errors as $error): ?><p><?= h($error) ?></p><?php endforeach; ?></div><?php endif; ?>
      <form method="post" action="<?= h(url('Auth', 'resetPassword', ['token' => $token])) ?>" class="login-form">
        <?= csrfField() ?>
        <input type="hidden" name="token" value="<?= h($token) ?>">
        <div class="login-field">
          <label for="matKhau">Mật khẩu mới</label>
          <input id="matKhau" name="matKhau" type="password" minlength="8" maxlength="200" autocomplete="new-password" required>
        </div>
        <div class="login-field">
          <label for="xacNhanMatKhau">Nhập lại mật khẩu</label>
          <input id="xacNhanMatKhau" name="xacNhanMatKhau" type="password" minlength="8" maxlength="200" autocomplete="new-password" required>
        </div>
        <button type="submit" class="login-submit">Đổi mật khẩu <span aria-hidden="true">→</span></button>
      </form>
    <?php endif; ?>
  </div>
</section>
<?php require __DIR__ . '/../layout/footer.php'; ?>
