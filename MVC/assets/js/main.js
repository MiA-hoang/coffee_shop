// Nâu Coffee – tương tác giao diện (không có logic nghiệp vụ)
(function () {
  'use strict';

  var header = document.querySelector('.site-header');
  var toggle = document.querySelector('.nav-toggle');
  var nav = document.getElementById('site-nav');

  // Đổ bóng cho header khi cuộn trang
  function onScroll() {
    if (header) header.classList.toggle('is-scrolled', window.scrollY > 8);
  }
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });

  // Mở/đóng menu trên điện thoại
  function setNav(open) {
    if (!toggle || !nav) return;
    nav.classList.toggle('is-open', open);
    toggle.setAttribute('aria-expanded', String(open));
    toggle.setAttribute('aria-label', open ? 'Đóng menu' : 'Mở menu');
  }
  if (toggle && nav) {
    toggle.addEventListener('click', function () { setNav(!nav.classList.contains('is-open')); });
    nav.addEventListener('click', function (e) { if (e.target.closest('a')) setNav(false); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') setNav(false); });
    window.addEventListener('resize', function () { if (window.innerWidth >= 900) setNav(false); });
  }

  // Lọc thực đơn ngay khi đổi danh mục
  var select = document.querySelector('.filter select');
  if (select) select.addEventListener('change', function () { select.form.submit(); });

  // Đổi ảnh CAPTCHA nếu ký tự bị nhiễu khó đọc.
  document.querySelectorAll('[data-captcha-widget]').forEach(function (widget) {
    var image = widget.querySelector('img');
    var button = widget.querySelector('[data-captcha-refresh]');
    if (image && button) {
      button.addEventListener('click', function () {
        image.src = image.getAttribute('data-base-src') + '&t=' + Date.now();
      });
    }
  });
})();
