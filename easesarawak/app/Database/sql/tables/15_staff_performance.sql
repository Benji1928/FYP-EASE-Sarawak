-- Staff Performance Table
CREATE TABLE Staff_Performance (
  performance_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  staff_id INT UNSIGNED NOT NULL,
  performance_date DATE NOT NULL,

  -- For drivers
  deliveries_completed INT DEFAULT 0,
  pickups_completed INT DEFAULT 0,
  average_delivery_time_minutes INT DEFAULT NULL,
  on_time_rate DECIMAL(5,2) DEFAULT NULL,

  -- For storage handlers
  bags_processed INT DEFAULT 0,
  incidents_reported INT DEFAULT 0,

  -- General
  shift_start_time DATETIME DEFAULT NULL,
  shift_end_time DATETIME DEFAULT NULL,
  hours_worked DECIMAL(5,2) DEFAULT NULL,

  notes TEXT DEFAULT NULL,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (staff_id) REFERENCES Admins(staff_id) ON DELETE CASCADE,

  INDEX idx_staff_date (staff_id, performance_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
