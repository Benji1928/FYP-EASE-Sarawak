-- Orders Table
CREATE TABLE Orders (
  order_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  special TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 = has special handling note',
  special_note TEXT DEFAULT NULL,
  service_type ENUM('Delivery','Storage','Storage_Delivery','Transfer') NOT NULL,
  order_details_json LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin CHECK (json_valid(order_details_json)),

  -- Timing
  dropoff_time DATETIME NOT NULL,
  pickup_time DATETIME NOT NULL,
  requested_delivery_time DATETIME DEFAULT NULL,

  -- Locations
  pickup_location_id INT UNSIGNED DEFAULT NULL,
  dropoff_location_id INT UNSIGNED NOT NULL,
  pickup_location_type VARCHAR(50) DEFAULT NULL,
  dropoff_location_type VARCHAR(50) DEFAULT NULL,

  -- Status & Management
  order_status ENUM('Pending','Confirmed','In_Storage','Out-for-Delivery','Completed','Cancelled') NOT NULL DEFAULT 'Pending',
  promo_code VARCHAR(255) DEFAULT NULL,
  is_cancelled TINYINT(1) DEFAULT 0,
  cancellation_reason TEXT DEFAULT NULL,
  cancellation_time DATETIME DEFAULT NULL,

  -- Pricing (ENHANCED)
  base_price DECIMAL(10,2) DEFAULT NULL,
  insurance_fee DECIMAL(10,2) DEFAULT 0.00,
  delivery_fee DECIMAL(10,2) DEFAULT 0.00,
  discount_amount DECIMAL(10,2) DEFAULT 0.00,
  total_amount DECIMAL(10,2) DEFAULT NULL,

  -- Luggage Info (ENHANCED)
  number_of_bags INT DEFAULT 1,
  has_oversized_bags BOOLEAN DEFAULT FALSE,
  has_special_items BOOLEAN DEFAULT FALSE,

  -- Booking Channel (ENHANCED)
  booking_channel VARCHAR(50) DEFAULT 'direct' COMMENT 'direct, partner, online, walk-in',
  booking_source VARCHAR(100) DEFAULT NULL,

  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  modified_by INT UNSIGNED DEFAULT NULL,
  payment_id INT UNSIGNED DEFAULT NULL,
  partner_id BIGINT UNSIGNED DEFAULT NULL,

  FOREIGN KEY (user_id) REFERENCES Users(user_id),
  FOREIGN KEY (pickup_location_id) REFERENCES Locations(location_id),
  FOREIGN KEY (dropoff_location_id) REFERENCES Locations(location_id),
  FOREIGN KEY (promo_code) REFERENCES Promo(promo_code),
  FOREIGN KEY (modified_by) REFERENCES Admins(staff_id),
  FOREIGN KEY (payment_id) REFERENCES Payments(payment_id),
  FOREIGN KEY (partner_id) REFERENCES Partners(partner_id),

  INDEX idx_user (user_id),
  INDEX idx_status (order_status),
  INDEX idx_service_type (service_type),
  INDEX idx_created_date (created_date),
  INDEX idx_pickup_time (pickup_time),
  INDEX idx_booking_channel (booking_channel)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
