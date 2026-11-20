-- Can be imported into a new or existing db_coffeeshop. No DROP statements.
-- Existing products/categories are kept; missing sample records are added.
CREATE DATABASE IF NOT EXISTS db_coffeeshop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_coffeeshop;
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS tblDanhMuc (
 maDanhMuc INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 tenDanhMuc VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tblSanPham (
 maSanPham INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 tenSanPham VARCHAR(150) NOT NULL,
 gia INT UNSIGNED NOT NULL,
 moTa VARCHAR(500) NULL,
 hinhAnh VARCHAR(255) NULL,
 maDanhMuc INT UNSIGNED NOT NULL,
 FOREIGN KEY (maDanhMuc) REFERENCES tblDanhMuc(maDanhMuc) ON DELETE RESTRICT,
 CHECK (gia > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tblNguoiDung (
 maNguoiDung INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 tenDangNhap VARCHAR(50) NOT NULL UNIQUE,
 email VARCHAR(255) NULL UNIQUE,
 soDienThoai VARCHAR(20) NULL,
 matKhau VARCHAR(255) NOT NULL,
 hoTen VARCHAR(100) NOT NULL,
 vaiTro VARCHAR(10) NOT NULL DEFAULT 'customer',
 CHECK (vaiTro IN ('customer','admin'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add email to older user tables without removing their existing rows.
SET @emailColumnExists = (
 SELECT COUNT(*) FROM information_schema.COLUMNS
 WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tblNguoiDung' AND COLUMN_NAME = 'email'
);
SET @addEmailSql = IF(@emailColumnExists = 0,
 'ALTER TABLE tblNguoiDung ADD COLUMN email VARCHAR(255) NULL UNIQUE AFTER tenDangNhap',
 'SELECT 1'
);
PREPARE addEmailStatement FROM @addEmailSql;
EXECUTE addEmailStatement;
DEALLOCATE PREPARE addEmailStatement;

-- Add phone to older account tables without removing existing rows.
SET @phoneColumnExists = (
 SELECT COUNT(*) FROM information_schema.COLUMNS
 WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tblNguoiDung' AND COLUMN_NAME = 'soDienThoai'
);
SET @addPhoneSql = IF(@phoneColumnExists = 0,
 'ALTER TABLE tblNguoiDung ADD COLUMN soDienThoai VARCHAR(20) NULL AFTER email',
 'SELECT 1'
);
PREPARE addPhoneStatement FROM @addPhoneSql;
EXECUTE addPhoneStatement;
DEALLOCATE PREPARE addPhoneStatement;

CREATE TABLE IF NOT EXISTS tblPasswordReset (
 maReset BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 maNguoiDung INT UNSIGNED NOT NULL,
 tokenHash CHAR(64) NOT NULL UNIQUE,
 expiresAt DATETIME NOT NULL,
 usedAt DATETIME NULL,
 createdAt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
 INDEX idx_password_reset_user (maNguoiDung),
 FOREIGN KEY (maNguoiDung) REFERENCES tblNguoiDung(maNguoiDung) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tblDonHang (
 maDonHang INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 maNguoiDung INT UNSIGNED NULL,
 tenKhach VARCHAR(100) NOT NULL,
 soDienThoai VARCHAR(20) NOT NULL,
 ngayDat DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
 tongTien INT UNSIGNED NOT NULL DEFAULT 0,
 INDEX idx_order_customer (maNguoiDung),
 FOREIGN KEY (maNguoiDung) REFERENCES tblNguoiDung(maNguoiDung) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Link future orders to the signed-in customer; old guest orders remain intact.
SET @orderUserColumnExists = (
 SELECT COUNT(*) FROM information_schema.COLUMNS
 WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tblDonHang' AND COLUMN_NAME = 'maNguoiDung'
);
SET @addOrderUserSql = IF(@orderUserColumnExists = 0,
 'ALTER TABLE tblDonHang ADD COLUMN maNguoiDung INT UNSIGNED NULL, ADD INDEX idx_order_customer (maNguoiDung), ADD CONSTRAINT fk_order_customer FOREIGN KEY (maNguoiDung) REFERENCES tblNguoiDung(maNguoiDung) ON DELETE SET NULL',
 'SELECT 1'
);
PREPARE addOrderUserStatement FROM @addOrderUserSql;
EXECUTE addOrderUserStatement;
DEALLOCATE PREPARE addOrderUserStatement;

CREATE TABLE IF NOT EXISTS tblChiTietDonHang (
 maChiTiet INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 maDonHang INT UNSIGNED NOT NULL,
 maSanPham INT UNSIGNED NOT NULL,
 soLuong SMALLINT UNSIGNED NOT NULL,
 donGia INT UNSIGNED NOT NULL,
 FOREIGN KEY (maDonHang) REFERENCES tblDonHang(maDonHang) ON DELETE CASCADE,
 FOREIGN KEY (maSanPham) REFERENCES tblSanPham(maSanPham) ON DELETE RESTRICT,
 CHECK (soLuong > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO tblDanhMuc (maDanhMuc,tenDanhMuc) VALUES
(1,'Espresso'),(2,'Latte'),(3,'Cold Brew'),(4,'Tea'),(5,'Pastry'),(6,'Seasonal');

INSERT INTO tblSanPham (tenSanPham,gia,moTa,maDanhMuc)
SELECT 'Espresso',35000,'Double shot, thick crema, bittersweet finish.',1 WHERE NOT EXISTS (SELECT 1 FROM tblSanPham WHERE tenSanPham='Espresso')
UNION ALL SELECT 'Americano',39000,'Espresso lengthened with hot water.',1 WHERE NOT EXISTS (SELECT 1 FROM tblSanPham WHERE tenSanPham='Americano')
UNION ALL SELECT 'Ristretto',37000,'A shorter, sweeter pull of espresso.',1 WHERE NOT EXISTS (SELECT 1 FROM tblSanPham WHERE tenSanPham='Ristretto')
UNION ALL SELECT 'Latte',49000,'Espresso with steamed milk and a thin layer of foam.',2 WHERE NOT EXISTS (SELECT 1 FROM tblSanPham WHERE tenSanPham='Latte')
UNION ALL SELECT 'Vanilla Latte',55000,'Latte sweetened with house-made vanilla syrup.',2 WHERE NOT EXISTS (SELECT 1 FROM tblSanPham WHERE tenSanPham='Vanilla Latte')
UNION ALL SELECT 'Mocha',55000,'Espresso, dark chocolate and steamed milk.',2 WHERE NOT EXISTS (SELECT 1 FROM tblSanPham WHERE tenSanPham='Mocha')
UNION ALL SELECT 'Classic Cold Brew',49000,'Steeped for 18 hours, smooth and low in acidity.',3 WHERE NOT EXISTS (SELECT 1 FROM tblSanPham WHERE tenSanPham='Classic Cold Brew')
UNION ALL SELECT 'Cold Brew Tonic',55000,'Cold brew over tonic water and orange peel.',3 WHERE NOT EXISTS (SELECT 1 FROM tblSanPham WHERE tenSanPham='Cold Brew Tonic')
UNION ALL SELECT 'Peach Tea',45000,'Black tea, peach slices and lemongrass.',4 WHERE NOT EXISTS (SELECT 1 FROM tblSanPham WHERE tenSanPham='Peach Tea')
UNION ALL SELECT 'Jasmine Green Tea',40000,'Lightly floral, served hot or iced.',4 WHERE NOT EXISTS (SELECT 1 FROM tblSanPham WHERE tenSanPham='Jasmine Green Tea')
UNION ALL SELECT 'Butter Croissant',35000,'Baked each morning.',5 WHERE NOT EXISTS (SELECT 1 FROM tblSanPham WHERE tenSanPham='Butter Croissant')
UNION ALL SELECT 'Basque Cheesecake',52000,'Burnt top, creamy centre.',5 WHERE NOT EXISTS (SELECT 1 FROM tblSanPham WHERE tenSanPham='Basque Cheesecake');
-- "Seasonal" has no products yet, so the report shows a category with zero items.

-- Attach sample photos when a product does not already have a custom photo.
UPDATE tblSanPham SET hinhAnh = 'espresso.jpg' WHERE tenSanPham = 'Espresso' AND hinhAnh IS NULL;
UPDATE tblSanPham SET hinhAnh = 'americano.jpg' WHERE tenSanPham = 'Americano' AND hinhAnh IS NULL;
UPDATE tblSanPham SET hinhAnh = 'latte.jpg' WHERE tenSanPham = 'Latte' AND hinhAnh IS NULL;
UPDATE tblSanPham SET hinhAnh = 'vanilla-latte.jpg' WHERE tenSanPham = 'Vanilla Latte' AND hinhAnh IS NULL;
UPDATE tblSanPham SET hinhAnh = 'mocha.jpg' WHERE tenSanPham = 'Mocha' AND hinhAnh IS NULL;
UPDATE tblSanPham SET hinhAnh = 'cold-brew.jpg' WHERE tenSanPham = 'Classic Cold Brew' AND hinhAnh IS NULL;

