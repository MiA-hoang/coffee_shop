<?php
// Đường dẫn gốc tới thư mục public (hoạt động với http://localhost/coffee_shop/public/index.php)
$base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$pageTitle = 'Nâu Coffee – Cà phê rang xay thủ công';

// Dữ liệu mẫu (chưa kết nối database)
$featured = [
    ['name' => 'Nâu Signature',   'desc' => 'Espresso đậm, sữa tươi và lớp kem cốt dừa béo nhẹ.', 'price' => 45000, 'tag' => 'Món của quán', 'tone' => '#7a4e33'],
    ['name' => 'Bạc xỉu kem muối', 'desc' => 'Vị sữa ngọt dịu, phủ kem muối mặn nhẹ ở cuối ngụm.',   'price' => 42000, 'tag' => 'Bán chạy',     'tone' => '#9a7556'],
    ['name' => 'Cold brew cam sả', 'desc' => 'Ủ lạnh 18 giờ, thêm cam tươi và chút sả thơm.',        'price' => 55000, 'tag' => 'Mới',          'tone' => '#556245'],
    ['name' => 'Cappuccino caramel', 'desc' => 'Bọt sữa mịn, caramel cháy nhẹ trên nền espresso.',    'price' => 49000, 'tag' => '',             'tone' => '#4a3426'],
];
$values = [
    ['num' => '2018', 'label' => 'Năm quán mở cửa'],
    ['num' => '12',   'label' => 'Nông trại cung cấp hạt'],
    ['num' => '7–22', 'label' => 'Giờ mở cửa mỗi ngày'],
];

require __DIR__ . '/../app/views/layouts/header.php';
?>

<!-- Biểu tượng ly dùng lại cho các thẻ món -->
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
    <symbol id="cup" viewBox="0 0 120 100">
        <path d="M24 30h60v22a30 24 0 0 1-60 0z" fill="currentColor"/>
        <path d="M84 36h6a10 10 0 0 1 0 20h-8" fill="none" stroke="currentColor" stroke-width="5" stroke-linecap="round"/>
        <ellipse cx="54" cy="84" rx="40" ry="7" fill="currentColor" opacity=".55"/>
    </symbol>
</svg>

<main>
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
                <img src="<?= $base ?>/assets/images/cafemuoi.jpg" alt="Ly cà phê muối kem sữa của Nâu Coffee">
                <span class="hero-image-caption">Đậm vị cà phê, dịu lớp kem muối</span>
            </div>
        </div>
    </section>

    <section class="highlights" aria-label="Điểm nổi bật của Nâu Coffee">
        <div class="container highlights-inner">
            <article><span class="highlight-icon" aria-hidden="true">✳</span><div><h2>Hạt chọn kỹ</h2><p>Chọn lọc từ những nông trại Tây Nguyên.</p></div></article>
            <article><span class="highlight-icon" aria-hidden="true">♨</span><div><h2>Rang mỗi ngày</h2><p>Rang mẻ nhỏ để giữ hương thơm tự nhiên.</p></div></article>
            <article><span class="highlight-icon" aria-hidden="true">♡</span><div><h2>Pha thủ công</h2><p>Mỗi ly được pha mới khi bạn gọi món.</p></div></article>
            <article><span class="highlight-icon" aria-hidden="true">⌂</span><div><h2>Góc quán yên</h2><p>Chậm lại một chút giữa ngày bận rộn.</p></div></article>
        </div>
    </section>

    <section class="section" id="thuc-don">
        <div class="container">
            <div class="section-head">
                <h2>Món nổi bật trong tuần</h2>
                <p>Bốn thức uống được khách gọi nhiều nhất, pha từ hạt rang trong ngày.</p>
            </div>

            <div class="grid">
                <?php foreach ($featured as $item): ?>
                    <article class="card">
                        <div class="card-media" style="--tone: <?= htmlspecialchars($item['tone'], ENT_QUOTES, 'UTF-8') ?>">
                            <?php if ($item['tag'] !== ''): ?>
                                <span class="badge"><?= htmlspecialchars($item['tag'], ENT_QUOTES, 'UTF-8') ?></span>
                            <?php endif; ?>
                            <svg viewBox="0 0 120 100" aria-hidden="true"><use href="#cup"/></svg>
                        </div>
                        <div class="card-body">
                            <div class="card-title-row">
                                <h3><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                                <span class="leader" aria-hidden="true"></span>
                                <span class="price"><?= number_format($item['price'], 0, ',', '.') ?>đ</span>
                            </div>
                            <p><?= htmlspecialchars($item['desc'], ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
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
                    <?php foreach ($values as $v): ?>
                        <li>
                            <strong><?= htmlspecialchars($v['num'], ENT_QUOTES, 'UTF-8') ?></strong>
                            <span><?= htmlspecialchars($v['label'], ENT_QUOTES, 'UTF-8') ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>
</main>

<?php require __DIR__ . '/../app/views/layouts/footer.php'; ?>
