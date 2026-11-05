// Nâu Coffee – JavaScript giao diện (không có logic nghiệp vụ)
(function () {
  'use strict';

  var header = document.querySelector('.site-header');
  var toggle = document.querySelector('.nav-toggle');
  var nav = document.getElementById('site-nav');
  var bar = document.querySelector('.announce');
  var closeBtn = document.querySelector('.announce-close');

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
    toggle.addEventListener('click', function () {
      setNav(!nav.classList.contains('is-open'));
    });
    // Chọn một liên kết thì tự đóng menu
    nav.addEventListener('click', function (e) {
      if (e.target.closest('a')) setNav(false);
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') setNav(false);
    });
    // Quay lại màn hình rộng thì đặt lại trạng thái
    window.addEventListener('resize', function () {
      if (window.innerWidth >= 900) setNav(false);
    });
  }

  // Đóng thanh thông báo
  if (bar && closeBtn) {
    closeBtn.addEventListener('click', function () {
      bar.hidden = true;
    });
  }
})();