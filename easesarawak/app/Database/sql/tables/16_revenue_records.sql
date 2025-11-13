-- Revenue Records Table
CREATE TABLE Revenue_Records (
  revenue_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED DEFAULT NULL,
  transaction_date DATE NOT NULL,

  -- Revenue breakdown
  service_revenue DECIMAL(10,2) DEFAULT 0.00,
  delivery_revenue DECIMAL(10,2) DEFAULT 0.00,
  insurance_revenue DECIMAL(10,2) DEFAULT 0.00,
  partner_commission DECIMAL(10,2) DEFAULT 0.00,
  net_revenue DECIMAL(10,2) NOT NULL,

  -- Classification
  revenue_channel VARCHAR(50) DEFAULT NULL COMMENT 'direct, partner',
  service_type VARCHAR(50) DEFAULT NULL,

  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE SET NULL,

  INDEX idx_date (transaction_date),
  INDEX idx_channel (revenue_channel)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
