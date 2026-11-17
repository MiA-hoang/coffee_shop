-- Import once into a new database. No DROP statements.
CREATE DATABASE IF NOT EXISTS db_coffeeshop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_coffeeshop;
SET NAMES utf8mb4;

CREATE TABLE tblDanhMuc (
 maDanhMuc INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 tenDanhMuc VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tblSanPham (
 maSanPham INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 tenSanPham VARCHAR(150) NOT NULL,
 gia INT UNSIGNED NOT NULL,
 moTa VARCHAR(500) NULL,
 hinhAnh VARCHAR(255) NULL,
 maDanhMuc INT UNSIGNED NOT NULL,
 FOREIGN KEY (maDanhMuc) REFERENCES tblDanhMuc(maDanhMuc) ON DELETE RESTRICT,
 CHECK (gia > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tblNguoiDung (
 maNguoiDung INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 tenDangNhap VARCHAR(50) NOT NULL UNIQUE,
 matKhau VARCHAR(255) NOT NULL,
 hoTen VARCHAR(100) NOT NULL,
 vaiTro VARCHAR(10) NOT NULL DEFAULT 'customer',
 CHECK (vaiTro IN ('customer','admin'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tblDonHang (
 maDonHang INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 tenKhach VARCHAR(100) NOT NULL,
 soDienThoai VARCHAR(20) NOT NULL,
 ngayDat DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
 tongTien INT UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tblChiTietDonHang (
 maChiTiet INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 maDonHang INT UNSIGNED NOT NULL,
 maSanPham INT UNSIGNED NOT NULL,
 soLuong SMALLINT UNSIGNED NOT NULL,
 donGia INT UNSIGNED NOT NULL,
 FOREIGN KEY (maDonHang) REFERENCES tblDonHang(maDonHang) ON DELETE CASCADE,
 FOREIGN KEY (maSanPham) REFERENCES tblSanPham(maSanPham) ON DELETE RESTRICT,
 CHECK (soLuong > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tblDanhMuc (maDanhMuc,tenDanhMuc) VALUES
(1,'Espresso'),(2,'Latte'),(3,'Cold Brew'),(4,'Tea'),(5,'Pastry'),(6,'Seasonal');

INSERT INTO tblSanPham (tenSanPham,gia,moTa,maDanhMuc) VALUES
('Espresso',35000,'Double shot, thick crema, bittersweet finish.',1),
('Americano',39000,'Espresso lengthened with hot water.',1),
('Ristretto',37000,'A shorter, sweeter pull of espresso.',1),
('Latte',49000,'Espresso with steamed milk and a thin layer of foam.',2),
('Vanilla Latte',55000,'Latte sweetened with house-made vanilla syrup.',2),
('Mocha',55000,'Espresso, dark chocolate and steamed milk.',2),
('Classic Cold Brew',49000,'Steeped for 18 hours, smooth and low in acidity.',3),
('Cold Brew Tonic',55000,'Cold brew over tonic water and orange peel.',3),
('Peach Tea',45000,'Black tea, peach slices and lemongrass.',4),
('Jasmine Green Tea',40000,'Lightly floral, served hot or iced.',4),
('Butter Croissant',35000,'Baked each morning.',5),
('Basque Cheesecake',52000,'Burnt top, creamy centre.',5);
-- "Seasonal" has no products yet, so the report shows a category with zero items.
