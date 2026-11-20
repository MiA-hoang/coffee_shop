Coffee Shop - PHP MVC starter
1. Copy this folder to C:/xampp/htdocs/CoffeeShop.
2. Start Apache and MySQL in XAMPP. Import database.sql in phpMyAdmin > Import. It can also be run on an existing db_coffeeshop to add missing schema/sample records.
3. Check the account in MVC/config/database.php. Default: root, empty password, database db_coffeeshop.
4. Open http://localhost/CoffeeShop/MVC/index.php
Requires PHP 7.4+ with pdo_mysql and mbstring; MySQL 8 or MariaDB 10.4+.
URLs use query parameters (index.php?controller=Product&action=index), so they work without mod_rewrite.

What works now
- Home (featured drinks), Menu (list, search, filter by category), product detail,
  Add product (validated, CSRF-protected), Categories, Report (statistics per category).
What is still a TODO stub (routed, shows a placeholder page)
- Cart, Order (checkout / history).

Authentication
- Login and public registration create customer accounts only; login, registration, and password reset use a distorted text CAPTCHA.
- Password reset sends a one-hour link by email. Configure PHP mail/SMTP and the sender in MVC/config/mail.php before using it.
- Existing users have a blank email until one is added. Re-import database.sql to add the email column and password-reset table without removing existing data.

Naming follows the exam starter: English class/file names, Vietnamese table and column names
(tblDanhMuc = category, tblSanPham = product, tblNguoiDung = user, tblDonHang = order, tblChiTietDonHang = order item).
Put product photos in MVC/assets/images/products/ and store the file name in tblSanPham.hinhAnh.
Sample product photos are included in MVC/assets/images/products/. Re-import database.sql to attach them to matching menu items without overwriting custom photos.
