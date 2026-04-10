-- SONNE database schema + seed data
-- Compatible with MySQL 5.7+ / MariaDB 10.3+

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS news_comments;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS product_images;
DROP TABLE IF EXISTS cart_items;
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS news;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS contacts;
DROP TABLE IF EXISTS faqs;
DROP TABLE IF EXISTS page_contents;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(120) NOT NULL,
    email VARCHAR(160) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NULL,
    address VARCHAR(255) NULL,
    avatar VARCHAR(255) NULL,
    role ENUM('member','admin') NOT NULL DEFAULT 'member',
    is_locked TINYINT(1) NOT NULL DEFAULT 0,
    login_attempts INT NOT NULL DEFAULT 0,
    locked_until DATETIME NULL,
    deleted_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    slug VARCHAR(140) NOT NULL UNIQUE,
    image VARCHAR(255) NULL,
    sort_order INT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    name VARCHAR(180) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    description TEXT NULL,
    price DECIMAL(12,2) NOT NULL DEFAULT 0,
    sale_price DECIMAL(12,2) NULL,
    stock INT NOT NULL DEFAULT 0,
    cover_image VARCHAR(255) NULL,
    is_featured TINYINT(1) NOT NULL DEFAULT 0,
    is_flash_sale TINYINT(1) NOT NULL DEFAULT 0,
    flash_ends_at DATETIME NULL,
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    deleted_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_products_category FOREIGN KEY (category_id) REFERENCES categories(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX idx_products_status (status),
    INDEX idx_products_category (category_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE product_images (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id INT UNSIGNED NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_product_images_product FOREIGN KEY (product_id) REFERENCES products(id)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE reviews (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    rating TINYINT UNSIGNED NOT NULL,
    comment TEXT NULL,
    is_deleted TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_reviews_product FOREIGN KEY (product_id) REFERENCES products(id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_reviews_user FOREIGN KEY (user_id) REFERENCES users(id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT uq_reviews_product_user UNIQUE (product_id, user_id),
    CONSTRAINT chk_reviews_rating CHECK (rating BETWEEN 1 AND 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE cart_items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    product_id INT UNSIGNED NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    added_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_cart_items_user FOREIGN KEY (user_id) REFERENCES users(id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_cart_items_product FOREIGN KEY (product_id) REFERENCES products(id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT uq_cart_user_product UNIQUE (user_id, product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE orders (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NULL,
    full_name VARCHAR(120) NOT NULL,
    email VARCHAR(160) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address VARCHAR(255) NOT NULL,
    note TEXT NULL,
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
    shipping_fee DECIMAL(12,2) NOT NULL DEFAULT 0,
    total DECIMAL(12,2) NOT NULL DEFAULT 0,
    payment_method ENUM('cod','bank_transfer','credit_card') NOT NULL DEFAULT 'cod',
    status ENUM('pending','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_orders_user FOREIGN KEY (user_id) REFERENCES users(id)
        ON UPDATE CASCADE ON DELETE SET NULL,
    INDEX idx_orders_status (status),
    INDEX idx_orders_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE order_items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id INT UNSIGNED NOT NULL,
    product_id INT UNSIGNED NULL,
    product_name VARCHAR(180) NOT NULL,
    cover_image VARCHAR(255) NULL,
    price DECIMAL(12,2) NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    CONSTRAINT fk_order_items_order FOREIGN KEY (order_id) REFERENCES orders(id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_order_items_product FOREIGN KEY (product_id) REFERENCES products(id)
        ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE news (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    author_id INT UNSIGNED NULL,
    title VARCHAR(220) NOT NULL,
    slug VARCHAR(240) NOT NULL UNIQUE,
    summary TEXT NULL,
    body LONGTEXT NULL,
    cover_image VARCHAR(255) NULL,
    meta_title VARCHAR(255) NULL,
    meta_description TEXT NULL,
    meta_keywords VARCHAR(255) NULL,
    status ENUM('draft','published') NOT NULL DEFAULT 'published',
    published_at DATETIME NULL,
    deleted_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_news_author FOREIGN KEY (author_id) REFERENCES users(id)
        ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE news_comments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    news_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    comment TEXT NOT NULL,
    is_deleted TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_news_comments_news FOREIGN KEY (news_id) REFERENCES news(id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_news_comments_user FOREIGN KEY (user_id) REFERENCES users(id)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE contacts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(120) NOT NULL,
    email VARCHAR(160) NOT NULL,
    phone VARCHAR(20) NULL,
    subject VARCHAR(180) NULL,
    message TEXT NOT NULL,
    status ENUM('unread','read','replied') NOT NULL DEFAULT 'unread',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE faqs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(255) NOT NULL,
    answer TEXT NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE page_contents (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    page_key VARCHAR(120) NOT NULL UNIQUE,
    title VARCHAR(255) NULL,
    content TEXT NULL,
    image VARCHAR(255) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO users (full_name, email, password, phone, role) VALUES
('Administrator', 'admin@sonne.vn', '$2y$10$92y9r7ANYW6491meTSOU4OCbSEQCMcuWCvoXC4JXWNssrw87pxoYG', '0900000000', 'admin'),
('Nguyen Van A', 'member@sonne.vn', '$2y$10$92y9r7ANYW6491meTSOU4OCbSEQCMcuWCvoXC4JXWNssrw87pxoYG', '0911111111', 'member');

INSERT INTO categories (name, slug, sort_order) VALUES
('Chăm sóc da', 'cham-soc-da', 1),
('Trang điểm', 'trang-diem', 2),
('Dưỡng thể', 'duong-the', 3),
('Nước hoa', 'nuoc-hoa', 4);

INSERT INTO products (category_id, name, slug, description, price, sale_price, stock, is_featured, is_flash_sale, flash_ends_at, status) VALUES
(1, 'Serum Vitamin C 15%', 'serum-vitamin-c-15', 'Serum làm sáng da và hỗ trợ mờ thâm.', 420000, 349000, 120, 1, 1, DATE_ADD(NOW(), INTERVAL 2 DAY), 'active'),
(1, 'Kem chống nắng SPF50+', 'kem-chong-nang-spf50', 'Bảo vệ da phổ rộng UVA/UVB.', 290000, 249000, 200, 1, 0, NULL, 'active'),
(2, 'Son lì Velvet Matte', 'son-li-velvet-matte', 'Chất son mịn, bền màu 8h.', 220000, NULL, 90, 1, 0, NULL, 'active'),
(3, 'Sữa dưỡng thể phục hồi', 'sua-duong-the-phuc-hoi', 'Giữ ẩm sâu, hỗ trợ phục hồi da khô.', 310000, 269000, 75, 0, 1, DATE_ADD(NOW(), INTERVAL 1 DAY), 'active'),
(4, 'Nước hoa Floral Bloom', 'nuoc-hoa-floral-bloom', 'Hương hoa nhẹ nhàng, thanh lịch.', 890000, 759000, 40, 0, 0, NULL, 'active');

INSERT INTO news (author_id, title, slug, summary, body, status, published_at, meta_title, meta_description, meta_keywords) VALUES
(1, 'Xu hướng skincare 2026', 'xu-huong-skincare-2026', 'Những xu hướng dưỡng da nổi bật năm 2026.', 'Nội dung bài viết mẫu về xu hướng skincare 2026.', 'published', NOW(), 'Xu hướng skincare 2026', 'Tổng hợp xu hướng skincare mới nhất.', 'skincare, xu huong, sonne'),
(1, 'Cách chọn serum phù hợp từng loại da', 'cach-chon-serum-phu-hop', 'Hướng dẫn chọn serum theo nhu cầu da.', 'Nội dung bài viết mẫu về cách chọn serum.', 'published', NOW(), 'Cách chọn serum phù hợp', 'Hướng dẫn chọn serum chuẩn.', 'serum, da dau, da kho');

INSERT INTO faqs (question, answer, sort_order) VALUES
('Thời gian giao hàng là bao lâu?', 'Thông thường từ 2-5 ngày làm việc tùy khu vực.', 1),
('Có được đổi trả sản phẩm không?', 'Bạn có thể đổi trả trong vòng 7 ngày theo chính sách.', 2),
('Làm sao để theo dõi đơn hàng?', 'Đăng nhập và vào mục Đơn hàng của tôi để theo dõi.', 3);

INSERT INTO page_contents (page_key, title, content) VALUES
('about_intro', 'Câu chuyện SONNE', 'SONNE là thương hiệu TMĐT tập trung vào trải nghiệm mua sắm chất lượng và minh bạch.'),
('about_mission', 'Sứ mệnh', 'Giúp khách hàng tiếp cận sản phẩm làm đẹp chính hãng với mức giá hợp lý.'),
('contact_phone', '+84 28 3800 0000', NULL),
('contact_email', 'support@sonne.vn', NULL),
('contact_address', '268 Ly Thuong Kiet, Quan 10, TP.HCM', NULL),
('services_hero', 'Dịch vụ của SONNE', 'Giải pháp bán hàng và vận hành toàn diện cho doanh nghiệp.'),
('pricing_hero', 'Bảng giá dịch vụ', 'Linh hoạt theo quy mô và nhu cầu phát triển.'),
('seller_hero', 'Đăng ký trở thành nhà bán hàng', 'Kết nối với tệp khách hàng lớn trên nền tảng SONNE.');

SET FOREIGN_KEY_CHECKS = 1;
