-- Operational Costs Table
CREATE TABLE Operational_Costs (
  cost_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  cost_date DATE NOT NULL,
  cost_category ENUM('hub_operation','logistics','marketing','staff','maintenance','utilities','other') NOT NULL,
  cost_subcategory VARCHAR(100) DEFAULT NULL,
  amount DECIMAL(10,2) NOT NULL,
  description TEXT DEFAULT NULL,
  is_recurring BOOLEAN DEFAULT FALSE,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  INDEX idx_date (cost_date),
  INDEX idx_category (cost_category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
