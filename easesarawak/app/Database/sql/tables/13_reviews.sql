-- Reviews Table
CREATE TABLE Reviews (
  review_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED DEFAULT NULL,
  user_id INT UNSIGNED DEFAULT NULL,
  rating TINYINT CHECK (rating BETWEEN 1 AND 5),
  comment TEXT DEFAULT NULL,
  source ENUM('Google','Website','Facebook','Others') NOT NULL DEFAULT 'Others',
  external_link VARCHAR(500) DEFAULT NULL,
  response_text TEXT DEFAULT NULL,
  response_date DATETIME DEFAULT NULL,
  is_public BOOLEAN DEFAULT TRUE,

  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE SET NULL,
  FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE SET NULL,

  INDEX idx_rating (rating),
  INDEX idx_source (source)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
