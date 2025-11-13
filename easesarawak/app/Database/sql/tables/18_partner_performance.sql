-- Partner Performance Table
CREATE TABLE Partner_Performance (
  performance_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  partner_id BIGINT UNSIGNED NOT NULL,
  period_start DATE NOT NULL,
  period_end DATE NOT NULL,
  total_bookings INT DEFAULT 0,
  completed_bookings INT DEFAULT 0,
  cancelled_bookings INT DEFAULT 0,
  total_revenue DECIMAL(10,2) DEFAULT 0.00,
  commission_paid DECIMAL(10,2) DEFAULT 0.00,
  average_rating DECIMAL(3,2) DEFAULT NULL,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (partner_id) REFERENCES Partners(partner_id) ON DELETE CASCADE,

  INDEX idx_partner_period (partner_id, period_start)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
