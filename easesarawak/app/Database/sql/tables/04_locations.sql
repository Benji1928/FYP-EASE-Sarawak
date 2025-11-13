-- Locations Table
CREATE TABLE Locations (
  location_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  category ENUM('Airport','Hotel','Shopping Mall','Hub','Partner_Location','Other') NOT NULL,
  address TEXT DEFAULT NULL,
  total_capacity INT DEFAULT NULL COMMENT 'number of bags for storage locations',
  current_occupancy INT DEFAULT 0,
  is_active BOOLEAN DEFAULT TRUE,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  INDEX idx_category (category),
  INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
