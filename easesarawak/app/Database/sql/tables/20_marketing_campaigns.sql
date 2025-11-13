-- Marketing Campaigns Table
CREATE TABLE Marketing_Campaigns (
  campaign_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  campaign_name VARCHAR(255) NOT NULL,
  campaign_type ENUM('email','social_media','partnership','paid_ads','referral') NOT NULL,
  start_date DATE DEFAULT NULL,
  end_date DATE DEFAULT NULL,
  budget DECIMAL(10,2) DEFAULT NULL,
  total_spend DECIMAL(10,2) DEFAULT 0.00,
  impressions INT DEFAULT 0,
  clicks INT DEFAULT 0,
  conversions INT DEFAULT 0,
  revenue_generated DECIMAL(10,2) DEFAULT 0.00,
  is_active BOOLEAN DEFAULT TRUE,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  INDEX idx_dates (start_date, end_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
