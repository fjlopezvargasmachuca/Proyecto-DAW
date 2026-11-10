-- Modelo nuevo: no se importan clientes/empleados reales, ni contraseñas del dump antiguo.
CREATE TABLE IF NOT EXISTS users (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 full_name VARCHAR(120) NOT NULL,
 email VARCHAR(190) NOT NULL UNIQUE,
 password_hash VARCHAR(255) NOT NULL,
 phone VARCHAR(25) NULL,
 address VARCHAR(255) NULL,
 role ENUM('customer','staff') NOT NULL DEFAULT 'customer',
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS parts (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 category ENUM('body','engine','paint','doors','wheels','drive','accessory') NOT NULL,
 name VARCHAR(100) NOT NULL,
 description VARCHAR(255) NOT NULL DEFAULT '',
 price DECIMAL(10,2) NOT NULL,
 active TINYINT(1) NOT NULL DEFAULT 1,
 UNIQUE KEY part_name_category (category,name), INDEX category_active (category,active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS orders (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id BIGINT UNSIGNED NOT NULL,
 assigned_staff_id BIGINT UNSIGNED NULL,
 status ENUM('pending','in_progress','completed') NOT NULL DEFAULT 'pending',
 total DECIMAL(12,2) NOT NULL,
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 completed_at TIMESTAMP NULL,
 CONSTRAINT fk_order_user FOREIGN KEY (user_id) REFERENCES users(id),
 CONSTRAINT fk_order_staff FOREIGN KEY (assigned_staff_id) REFERENCES users(id) ON DELETE SET NULL,
 INDEX idx_order_user (user_id,created_at), INDEX idx_order_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS order_items (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 order_id BIGINT UNSIGNED NOT NULL,
 part_id INT UNSIGNED NULL,
 category VARCHAR(30) NOT NULL,
 part_name VARCHAR(100) NOT NULL,
 unit_price DECIMAL(10,2) NOT NULL,
 CONSTRAINT fk_item_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
 CONSTRAINT fk_item_part FOREIGN KEY (part_id) REFERENCES parts(id) ON DELETE SET NULL,
 INDEX idx_item_part (part_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS order_steps (
 order_id BIGINT UNSIGNED NOT NULL,
 category ENUM('body','engine','paint','doors','wheels','drive','accessory') NOT NULL,
 completed_at TIMESTAMP NULL,
 PRIMARY KEY (order_id,category),
 CONSTRAINT fk_step_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS repair_requests (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id BIGINT UNSIGNED NOT NULL,
 make VARCHAR(80) NOT NULL, model VARCHAR(80) NOT NULL,
 license_plate VARCHAR(20) NOT NULL, pickup_address VARCHAR(255) NOT NULL,
 description TEXT NOT NULL,
 status ENUM('received','in_transit','in_workshop','ready','delivered') NOT NULL DEFAULT 'received',
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 CONSTRAINT fk_repair_user FOREIGN KEY (user_id) REFERENCES users(id),
 INDEX idx_repair_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS listings (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id BIGINT UNSIGNED NOT NULL,
 make VARCHAR(80) NOT NULL, model VARCHAR(80) NOT NULL,
 mileage INT UNSIGNED NOT NULL, price DECIMAL(12,2) NOT NULL,
 description TEXT NOT NULL, is_active TINYINT(1) NOT NULL DEFAULT 1,
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_listing_user FOREIGN KEY (user_id) REFERENCES users(id),
 INDEX idx_listing_active (is_active,created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS contact_messages (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(120) NOT NULL, email VARCHAR(190) NOT NULL,
 message TEXT NOT NULL,
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
