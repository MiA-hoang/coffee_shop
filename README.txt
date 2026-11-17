Coffee Shop - PHP MVC starter
1. Copy this folder to C:/xampp/htdocs/CoffeeShop.
2. Start Apache and MySQL in XAMPP. Import database.sql once (phpMyAdmin > Import).
3. Check the account in MVC/config/database.php. Default: root, empty password, database db_coffeeshop.
4. Open http://localhost/CoffeeShop/MVC/index.php
Requires PHP 7.4+ with pdo_mysql and mbstring; MySQL 8 or MariaDB 10.4+.
URLs use query parameters (index.php?controller=Product&action=index), so they work without mod_rewrite.

What works now
- Home (featured drinks), Menu (list, search, filter by category), product detail,
  Add product (validated, CSRF-protected), Categories, Report (statistics per category).
What is still a TODO stub (routed, shows a placeholder page)
- Cart, Order (checkout / history), Auth (login). Tables for them already exist in database.sql.

Naming follows the exam starter: English class/file names, Vietnamese table and column names
(tblDanhMuc = category, tblSanPham = product, tblNguoiDung = user, tblDonHang = order, tblChiTietDonHang = order item).
Put product photos in MVC/assets/images/products/ and store the file name in tblSanPham.hinhAnh.
