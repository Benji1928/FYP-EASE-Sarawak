-- Tourist Arrivals Data Table
CREATE TABLE Tourist_Arrivals_Data (
  arrival_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  period_start DATE NOT NULL,
  period_end DATE NOT NULL,
  location VARCHAR(100) NOT NULL DEFAULT 'Kuching',
  total_arrivals INT DEFAULT NULL,
  international_arrivals INT DEFAULT NULL,
  domestic_arrivals INT DEFAULT NULL,
  data_source VARCHAR(255) DEFAULT NULL,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  UNIQUE KEY unique_period_location (period_start, location),
  INDEX idx_period (period_start)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
