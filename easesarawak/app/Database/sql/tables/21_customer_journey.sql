-- Customer Journey Table
CREATE TABLE Customer_Journey (
  journey_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  order_id INT UNSIGNED DEFAULT NULL,

  -- Journey stages
  awareness_source VARCHAR(100) DEFAULT NULL,
  first_interaction_date DATE DEFAULT NULL,
  first_booking_date DATE DEFAULT NULL,

  -- Engagement
  website_visits INT DEFAULT 0,
  email_opens INT DEFAULT 0,
  email_clicks INT DEFAULT 0,

  -- Service usage
  service_tier_used VARCHAR(50) DEFAULT NULL,
  satisfaction_score INT DEFAULT NULL,

  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
