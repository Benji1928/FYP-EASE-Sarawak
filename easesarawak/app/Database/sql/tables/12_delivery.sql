-- Delivery Table
CREATE TABLE Delivery (
  delivery_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED NOT NULL,
  driver_id INT UNSIGNED NOT NULL,
  vehicle_id INT UNSIGNED DEFAULT NULL,
  status ENUM('Pending','Assigned','On Route','Delivered','Failed') NOT NULL DEFAULT 'Pending',
  assigned_at DATETIME DEFAULT NULL,
  pickup_started_at DATETIME DEFAULT NULL,
  pickup_completed_at DATETIME DEFAULT NULL,
  delivery_started_at DATETIME DEFAULT NULL,
  completed_time DATETIME DEFAULT NULL,
  actual_duration_minutes INT DEFAULT NULL,
  distance_km DECIMAL(8,2) DEFAULT NULL,
  on_time BOOLEAN DEFAULT NULL,
  delay_minutes INT DEFAULT 0,

  delivery_notes TEXT DEFAULT NULL,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE,
  FOREIGN KEY (driver_id) REFERENCES Admins(staff_id),

  INDEX idx_driver (driver_id),
  INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
