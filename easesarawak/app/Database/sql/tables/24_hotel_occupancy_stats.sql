-- Hotel Occupancy Stats Table
CREATE TABLE Hotel_Occupancy_Stats (
  occupancy_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  period_date DATE NOT NULL,
  location VARCHAR(100) DEFAULT 'Kuching',
  average_occupancy_rate DECIMAL(5,2) DEFAULT NULL,
  total_rooms_available INT DEFAULT NULL,
  rooms_occupied INT DEFAULT NULL,
  data_source VARCHAR(255) DEFAULT NULL,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  INDEX idx_date (period_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
