-- Incidents Table
CREATE TABLE Incidents (
  incident_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED DEFAULT NULL,
  incident_type ENUM('lost','damaged','delayed','theft','security_breach','other') NOT NULL,
  incident_date DATETIME NOT NULL,
  incident_location VARCHAR(255) DEFAULT NULL,

  -- Details
  severity ENUM('low','medium','high','critical') DEFAULT 'medium',
  description TEXT NOT NULL,
  cause TEXT DEFAULT NULL,

  -- People involved
  reported_by_user_id INT UNSIGNED DEFAULT NULL,
  reported_by_staff_id INT UNSIGNED DEFAULT NULL,

  -- Resolution
  status ENUM('reported','investigating','resolved','closed') DEFAULT 'reported',
  resolution_notes TEXT DEFAULT NULL,
  resolved_date DATETIME DEFAULT NULL,

  -- Financial impact
  estimated_cost DECIMAL(10,2) DEFAULT NULL,
  actual_cost DECIMAL(10,2) DEFAULT NULL,

  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE SET NULL,
  FOREIGN KEY (reported_by_user_id) REFERENCES Users(user_id),
  FOREIGN KEY (reported_by_staff_id) REFERENCES Admins(staff_id),

  INDEX idx_type (incident_type),
  INDEX idx_date (incident_date),
  INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
