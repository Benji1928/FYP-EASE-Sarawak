-- Travel Documents Table
CREATE TABLE Travel_Documents (
  doc_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED NOT NULL,
  doc_type ENUM('Passport','Visa','Ticket','Insurance','Other') NOT NULL,
  file_name VARCHAR(255) NOT NULL,
  file_path VARCHAR(255) NOT NULL,
  uploaded_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  verified TINYINT(1) DEFAULT 0,
  verified_by INT UNSIGNED DEFAULT NULL,
  verified_date DATETIME DEFAULT NULL,
  notes TEXT DEFAULT NULL,
  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE,
  FOREIGN KEY (verified_by) REFERENCES Admins(staff_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
