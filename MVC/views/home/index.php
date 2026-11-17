<?php
$fullWidth = true;
require __DIR__ . '/../layout/header.php';
$tones = ['#7a4e33', '#9a7556', '#556245', '#4a3426'];
$highlights = [
  ['icon' => '✳', 'title' => 'Hạt chọn kỹ', 'text' => 'Chọn lọc từ những nông trại Tây Nguyên.'],
  ['icon' => '♨', 'title' => 'Rang mỗi ngày', 'text' => 'Rang mẻ nhỏ để giữ hương thơm tự nhiên.'],
  ['icon' => '♡', 'title' => 'Pha thủ công', 'text' => 'Mỗi ly được pha mới khi bạn gọi món.'],
  ['icon' => '⌂', 'title' => 'Góc quán yên', 'text' => 'Chậm lại một chút giữa ngày bận rộn.'],
];
?>
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <symbol id="cup" viewBox="0 0 120 100">
    <path d="M24 30h60v22a30 24 0 0 1-60 0z" fill="currentColor"/>
    <path d="M84 36h6a10 10 0 0 1 0 20h-8" fill="none" stroke="currentColor" stroke-width="5" stroke-linecap="round"/>
    <ellipse cx="54" cy="84" rx="40" ry="7" fill="currentColor" opacity=".55"/>
  </symbol>
</svg>

<section class="hero">
  <div class="container hero-inner">
    <div class="hero-text">
      <h1>Một tách nâu, một buổi chiều chậm lại.</h1>
      <p class="lead">Nâu Coffee rang xay hạt theo từng mẻ nhỏ, pha thủ công và phục vụ trong không gian yên tĩnh. Ghé quán, ngồi xuống và uống từ từ.</p>
      <div class="hero-actions">
        <a class="btn btn-light" href="#thuc-don">Xem món nổi bật</a>
        <a class="btn btn-ghost" href="#lien-he">Tìm đường đến quán</a>
      </div>
      <p class="hero-hours">Mở cửa hằng ngày, 7:00 – 22:00</p>
    </div>

    <div class="hero-visual">
      <img src="assets/images/banner/cafemuoi.jpg" alt="Ly cà phê muối kem sữa của Nâu Coffee">
      <span class="hero-image-caption">Đậm vị cà phê, dịu lớp kem muối</span>
    </div>
  </div>
</section>

<section class="highlights" aria-label="Điểm nổi bật của Nâu Coffee">
  <div class="container highlights-inner">
    <?php foreach ($highlights as $h): ?>
      <article>
        <span class="highlight-icon" aria-hidden="true"><?= $h['icon'] ?></span>
        <div><h2><?= h($h['title']) ?></h2><p><?= h($h['text']) ?></p></div>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<section class="section" id="thuc-don">
  <div class="container">
    <div class="section-head">
      <h2>Món nổi bật trong tuần</h2>
      <p>Các thức uống được khách gọi nhiều nhất, pha từ hạt rang trong ngày.</p>
    </div>

    <?php if ($dbError): ?>
      <p class="notice">Chưa kết nối được cơ sở dữ liệu. Hãy import <code>database.sql</code> và kiểm tra <code>config/database.php</code>.</p>
    <?php elseif (!$featured): ?>
      <p class="empty">Chưa có món nào. <a href="<?= h(url('Product', 'create')) ?>">Thêm món đầu tiên</a>.</p>
    <?php else: ?>
      <div class="grid">
        <?php foreach ($featured as $i => $item): $img = productImage($item['hinhAnh']); ?>
          <article class="card">
            <div class="card-media" style="--tone: <?= $tones[$i % count($tones)] ?>">
              <?php if ($img): ?>
                <img src="<?= h($img) ?>" alt="<?= h($item['tenSanPham']) ?>">
              <?php else: ?>
                <svg viewBox="0 0 120 100" aria-hidden="true"><use href="#cup"/></svg>
              <?php endif; ?>
            </div>
            <div class="card-body">
              <div class="card-title-row">
                <h3><a href="<?= h(url('Product', 'detail', ['id' => (int)$item['maSanPham']])) ?>"><?= h($item['tenSanPham']) ?></a></h3>
                <span class="leader" aria-hidden="true"></span>
                <span class="price"><?= h(formatPrice($item['gia'])) ?></span>
              </div>
              <p><?= h($item['moTa'] ?? '') ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<section class="section about" id="cau-chuyen">
  <div class="container about-inner">
    <div class="about-visual">
      <p class="about-quote">Cà phê ngon bắt đầu từ việc không vội.</p>
      <p class="about-sign">Nhóm rang xay Nâu Coffee</p>
    </div>
    <div class="about-text">
      <h2>Quán nhỏ, hạt chọn kỹ</h2>
      <p>Chúng mình chọn hạt trực tiếp từ các nông trại Tây Nguyên, rang vừa tay để giữ vị chua nhẹ, hậu ngọt và mùi thơm của hạt. Mỗi ly được pha theo từng phần nhỏ, không pha sẵn.</p>
      <p>Không gian quán dùng gỗ, vải lanh và nhiều cây xanh, để bạn làm việc, đọc sách hoặc chỉ ngồi nhìn mưa.</p>
      <ul class="values">
        <li><strong>2018</strong><span>Năm quán mở cửa</span></li>
        <li><strong>12</strong><span>Nông trại cung cấp hạt</span></li>
        <li><strong>7–22</strong><span>Giờ mở cửa mỗi ngày</span></li>
      </ul>
    </div>
  </div>
</section>
