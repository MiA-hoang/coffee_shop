<?php require __DIR__ . '/../layout/header.php'; ?>
<section class="login-wrap" aria-labelledby="login-title">
  <div class="login-card">
    <div class="login-art">
      <img class="login-bg-image" src="assets/images/banner/cafemuoi.jpg" alt="" aria-hidden="true">
      <div class="login-brand-lockup">
        <span class="login-logo-mark" aria-hidden="true">
          <svg viewBox="0 0 64 64"><ellipse cx="32" cy="32" rx="17" ry="25" transform="rotate(35 32 32)" fill="currentColor"/><path d="M20 17c12 8 16 20 28 30" stroke="#fbf7f0" stroke-width="3" fill="none" stroke-linecap="round"/></svg>
        </span>
        <span class="login-brand-name">Nâu Coffee</span>
      </div>
      <div class="login-art-copy">
        <span class="login-kicker">CÀ PHÊ RANG XAY · TỪ 2018</span>
        <p>Chậm một chút,<br><span class="login-slogan-second">thưởng thức trọn vị.</span></p>
        <span class="login-art-note">Một góc nhỏ để ngày dịu lại.</span>
      </div>
    </div>
    <div class="login-panel">
      <div class="login-heading">
        <p class="eyebrow">Chào mừng bạn trở lại</p>
        <h1 id="login-title">Đăng nhập</h1>
        <p class="login-subtitle">Đăng nhập để tiếp tục ghé thăm Nâu Coffee.</p>
      </div>
      <?php if (($_GET['registered'] ?? '') === '1'): ?>
        <div class="register-success" role="status">Tạo tài khoản thành công. Bạn có thể đăng nhập ngay.</div>
      <?php endif; ?>
      <?php if ($errors): ?>
        <div class="login-error" role="alert"><strong>Chưa đăng nhập được</strong><?php foreach ($errors as $error): ?><p><?= h($error) ?></p><?php endforeach; ?></div>
      <?php endif; ?>
      <form method="post" action="<?= h(url('Auth', 'login')) ?>" class="login-form">
        <?= csrfField() ?>
        <div class="login-field">
          <label for="tenDangNhap">Tên đăng nhập</label>
          <input id="tenDangNhap" name="tenDangNhap" type="text" maxlength="50" autocomplete="username" placeholder="Nhập tên đăng nhập" required value="<?= h($username) ?>">
        </div>
        <div class="login-field">
          <label for="matKhau">Mật khẩu</label>
          <input id="matKhau" name="matKhau" type="password" autocomplete="current-password" placeholder="Nhập mật khẩu" required>
        </div>
        <div class="login-field">
          <label for="captcha">Nhập mã trong ảnh</label>
          <?= captchaWidget() ?>
          <input id="captcha" name="captcha" type="text" maxlength="5" autocapitalize="characters" autocomplete="off" spellcheck="false" placeholder="Gõ lại 5 ký tự" required>
        </div>
        <button type="submit" class="login-submit">Đăng nhập <span aria-hidden="true">→</span></button>
      </form>
      <div class="auth-links auth-actions">
        <a href="<?= h(url('Auth', 'register')) ?>">Đăng ký</a>
        <span class="auth-divider" aria-hidden="true">·</span>
        <a href="<?= h(url('Auth', 'forgotPassword')) ?>">Quên mật khẩu?</a>
      </div>
      <p class="login-footnote"><span aria-hidden="true">✦</span> Chậm một chút, thưởng thức trọn vị.</p>
    </div>
  </div>
</section>
<?php require __DIR__ . '/../layout/footer.php'; ?>
