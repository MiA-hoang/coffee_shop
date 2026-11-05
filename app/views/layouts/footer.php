<?php
$base = $base ?? rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
?>
<footer class="site-footer" id="lien-he">
    <div class="container footer-grid">
        <div>
            <a class="logo" href="<?= $base ?>/index.php">
                <svg viewBox="0 0 32 32" aria-hidden="true"><ellipse cx="16" cy="16" rx="9" ry="13" transform="rotate(35 16 16)" fill="currentColor"/><path d="M9 8c6 4 8 10 14 16" stroke="#241810" stroke-width="2" fill="none" stroke-linecap="round"/></svg>
                Nâu Coffee
            </a>
            <p class="footer-about">Cà phê rang xay thủ công, pha chậm và phục vụ tử tế. Một góc yên tĩnh để bạn nghỉ giữa ngày.</p>
        </div>

        <div>
            <h4>Khám phá</h4>
            <ul>
                <li><a href="<?= $base ?>/index.php">Trang chủ</a></li>
                <li><a href="#thuc-don">Thực đơn nổi bật</a></li>
                <li><a href="#cau-chuyen">Câu chuyện của quán</a></li>
            </ul>
        </div>

        <div>
            <h4>Liên hệ</h4>
            <ul>
                <li>123 Đường Cà Phê, Phường Trung Tâm</li>
                <li><a href="tel:0900123456">0900 123 456</a></li>
                <li><a href="mailto:hello@naucoffee.vn">hello@naucoffee.vn</a></li>
            </ul>
        </div>

        <div>
            <h4>Giờ mở cửa</h4>
            <ul>
                <li>Thứ Hai – Thứ Sáu: 7:00 – 22:00</li>
                <li>Thứ Bảy – Chủ Nhật: 7:30 – 22:30</li>
            </ul>
        </div>
    </div>

    <div class="container footer-bottom">
        <p>&copy; <?= date('Y') ?> Nâu Coffee. Bảo lưu mọi quyền.</p>
        <p>Dữ liệu trên trang là nội dung mẫu.</p>
    </div>
</footer>

<script src="<?= $base ?>/assets/js/main.js" defer></script>
</body>
</html>