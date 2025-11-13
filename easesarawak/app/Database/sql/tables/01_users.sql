-- Users Table
CREATE TABLE Users (
  user_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(255) NOT NULL,
  last_name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  phone VARCHAR(30) NOT NULL,
  social VARCHAR(50) DEFAULT NULL,
  social_num VARCHAR(50) DEFAULT NULL,
  nationality VARCHAR(100) DEFAULT NULL,
  customer_type ENUM('tourist','business_traveller','event_attendee','medical_tourist','international_student','local') DEFAULT NULL,
  customer_segment ENUM('short_stay','layover','long_stay') DEFAULT NULL,
  source_of_booking VARCHAR(100) DEFAULT NULL COMMENT 'online, walk-in, referral, partner',
  how_heard_about_us TEXT DEFAULT NULL,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  total_bookings INT DEFAULT 0,
  customer_acquisition_cost DECIMAL(10,2) DEFAULT NULL,
  is_active BOOLEAN DEFAULT TRUE,

  INDEX idx_email (email),
  INDEX idx_customer_type (customer_type),
  INDEX idx_nationality (nationality)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
