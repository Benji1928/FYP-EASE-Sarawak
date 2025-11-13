-- Local Events Table
CREATE TABLE Local_Events (
  event_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  event_name VARCHAR(255) NOT NULL,
  event_type VARCHAR(100) DEFAULT NULL COMMENT 'festival, conference, sports, concert',
  event_start_date DATE NOT NULL,
  event_end_date DATE NOT NULL,
  location VARCHAR(255) DEFAULT NULL,
  expected_attendance INT DEFAULT NULL,
  impact_level ENUM('low','medium','high') DEFAULT 'medium',
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  INDEX idx_dates (event_start_date, event_end_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
