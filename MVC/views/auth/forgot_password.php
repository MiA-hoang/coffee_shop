<?php require __DIR__ . '/../layout/header.php'; ?>
<section class="login-wrap" aria-labelledby="forgot-title">
  <div class="register-card">
    <a class="register-brand" href="<?= h(url('Home')) ?>">
      <span class="login-logo-mark" aria-hidden="true">
        <svg viewBox="0 0 64 64"><ellipse cx="32" cy="32" rx="17" ry="25" transform="rotate(35 32 32)" fill="currentColor"/><path d="M20 17c12 8 16 20 28 30" stroke="#fbf7f0" stroke-width="3" fill="none" stroke-linecap="round"/></svg>
      </span><span>Nâu Coffee</span>
    </a>
    <div class="login-heading">
      <p class="eyebrow">Khôi phục tài khoản</p>
      <h1 id="forgot-title">Quên mật khẩu?</h1>
      <p class="login-subtitle">Nhập email đã đăng ký, mình sẽ gửi link đặt mật khẩu mới.</p>
    </div>
    <?php if ($sent): ?>
      <div class="register-success" role="status">Nếu email thuộc một tài khoản, link khôi phục sẽ được gửi đến hộp thư. Link có hiệu lực trong 60 phút.</div>
    <?php endif; ?>
    <?php if ($errors): ?>
      <div class="login-error" role="alert"><?php foreach ($errors as $error): ?><p><?= h($error) ?></p><?php endforeach; ?></div>
    <?php endif; ?>
    <form method="post" action="<?= h(url('Auth', 'forgotPassword')) ?>" class="login-form">
      <?= csrfField() ?>
      <div class="login-field">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" maxlength="255" autocomplete="email" placeholder="ban@example.com" required value="<?= h($email) ?>">
      </div>
      <div class="login-field">
        <label for="captcha">Nhập mã trong ảnh</label>
        <?= captchaWidget() ?>
        <input id="captcha" name="captcha" type="text" maxlength="5" autocapitalize="characters" autocomplete="off" spellcheck="false" placeholder="Gõ lại 5 ký tự" required>
      </div>
      <button type="submit" class="login-submit">Gửi link khôi phục <span aria-hidden="true">→</span></button>
    </form>
    <p class="auth-links"><a href="<?= h(url('Auth', 'login')) ?>">← Quay lại đăng nhập</a></p>
  </div>
</section>
<?php require __DIR__ . '/../layout/footer.php'; ?>
