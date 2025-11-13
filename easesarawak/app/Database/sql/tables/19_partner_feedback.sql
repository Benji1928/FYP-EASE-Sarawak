-- Partner Feedback Table
CREATE TABLE Partner_Feedback (
  feedback_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  partner_id BIGINT UNSIGNED NOT NULL,
  feedback_date DATE NOT NULL,
  feedback_type ENUM('complaint','suggestion','praise') NOT NULL,
  feedback_text TEXT DEFAULT NULL,
  resolved BOOLEAN DEFAULT FALSE,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (partner_id) REFERENCES Partners(partner_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
