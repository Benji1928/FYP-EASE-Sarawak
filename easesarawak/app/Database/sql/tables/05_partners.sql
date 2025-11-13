-- Partners Table
CREATE TABLE Partners (
  partner_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  commission_rate DECIMAL(8,2) DEFAULT 0.00,
  type ENUM('Hotel','Airbnb','TourAgency','Event','Airline','Travel_Agency','Other') NOT NULL,
  contact_person VARCHAR(255) DEFAULT NULL,
  contact_email VARCHAR(255) DEFAULT NULL,
  contact_phone VARCHAR(20) DEFAULT NULL,
  payment_terms VARCHAR(100) DEFAULT NULL,
  contract_start_date DATE DEFAULT NULL,
  contract_end_date DATE DEFAULT NULL,
  is_active BOOLEAN DEFAULT TRUE,
  address TEXT DEFAULT NULL,

  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  INDEX idx_type (type),
  INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
