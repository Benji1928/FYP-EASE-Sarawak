-- Traffic Route Data Table
CREATE TABLE Traffic_Route_Data (
  traffic_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  route_name VARCHAR(255) DEFAULT NULL,
  origin_location VARCHAR(255) DEFAULT NULL,
  destination_location VARCHAR(255) DEFAULT NULL,
  log_datetime DATETIME NOT NULL,
  average_travel_time_minutes INT DEFAULT NULL,
  distance_km DECIMAL(8,2) DEFAULT NULL,
  traffic_condition ENUM('light','moderate','heavy','severe') DEFAULT 'moderate',
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  INDEX idx_datetime (log_datetime)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
