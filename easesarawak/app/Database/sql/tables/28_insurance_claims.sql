-- Insurance Claims Table
CREATE TABLE Insurance_Claims (
  claim_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  incident_id INT UNSIGNED DEFAULT NULL,
  order_id INT UNSIGNED DEFAULT NULL,
  user_id INT UNSIGNED DEFAULT NULL,

  claim_reference VARCHAR(100) UNIQUE,
  claim_date DATE NOT NULL,
  claim_amount DECIMAL(10,2) NOT NULL,
  claim_status ENUM('submitted','under_review','approved','paid','rejected') DEFAULT 'submitted',

  -- Insurance details
  insurance_provider VARCHAR(255) DEFAULT NULL,
  policy_number VARCHAR(100) DEFAULT NULL,
  coverage_type VARCHAR(100) DEFAULT NULL,

  -- Payout
  approved_amount DECIMAL(10,2) DEFAULT NULL,
  payout_date DATE DEFAULT NULL,
  payout_reference VARCHAR(100) DEFAULT NULL,

  -- Documentation
  supporting_documents TEXT DEFAULT NULL,
  notes TEXT DEFAULT NULL,

  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  FOREIGN KEY (incident_id) REFERENCES Incidents(incident_id) ON DELETE CASCADE,
  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE SET NULL,
  FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE SET NULL,

  INDEX idx_status (claim_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
