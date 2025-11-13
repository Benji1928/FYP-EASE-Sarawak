-- Promo Table
CREATE TABLE Promo (
  promo_code VARCHAR(255) PRIMARY KEY,
  discount_type ENUM('Flat','Percent') NOT NULL,
  discount_value DECIMAL(8,2) NOT NULL,
  start_date DATETIME NOT NULL,
  end_date DATETIME NOT NULL,
  usage_limit INT DEFAULT NULL COMMENT 'NULL = unlimited',
  times_used INT DEFAULT 0,
  is_active BOOLEAN DEFAULT TRUE,

  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  created_by INT UNSIGNED NOT NULL COMMENT 'Tracks which admin created the promo',
  FOREIGN KEY (created_by) REFERENCES Admins(staff_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
