-- Storage Tracking Table
CREATE TABLE Storage_Tracking (
  tracking_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED NOT NULL,
  location_id INT UNSIGNED DEFAULT NULL,

  -- Time stamps
  check_in_time DATETIME DEFAULT NULL,
  storage_start_time DATETIME DEFAULT NULL,
  storage_end_time DATETIME DEFAULT NULL,
  pickup_time DATETIME DEFAULT NULL,

  -- Staff handling
  checked_in_by INT UNSIGNED DEFAULT NULL,
  retrieved_by INT UNSIGNED DEFAULT NULL,

  storage_notes TEXT DEFAULT NULL,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE,
  FOREIGN KEY (location_id) REFERENCES Locations(location_id),
  FOREIGN KEY (checked_in_by) REFERENCES Admins(staff_id),
  FOREIGN KEY (retrieved_by) REFERENCES Admins(staff_id),

  INDEX idx_order (order_id),
  INDEX idx_location (location_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
