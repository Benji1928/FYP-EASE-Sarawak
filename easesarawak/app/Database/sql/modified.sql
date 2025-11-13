CREATE TABLE Users (
  user_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(255) NOT NULL,
  last_name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  phone VARCHAR(30) NOT NULL,
  social VARCHAR(50) DEFAULT NULL,
  social_num VARCHAR(50) DEFAULT NULL
);


CREATE TABLE Admins (
  staff_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  staff_name VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  role ENUM('Admin','Superadmin') NOT NULL DEFAULT 'Admin',
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  modified_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE Promo (
  promo_code VARCHAR(255) PRIMARY KEY,
  discount_type ENUM('Flat','Percent') NOT NULL,
  discount_value DECIMAL(8,2) NOT NULL,
  start_date DATETIME NOT NULL,
  end_date DATETIME NOT NULL,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  created_by INT UNSIGNED NOT NULL COMMENT 'Tracks which admin created the promo',
  FOREIGN KEY (created_by) REFERENCES Admins(staff_id)
);

=
CREATE TABLE Locations (
  location_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  category ENUM('Airport','Hotel','Shopping Mall','Other') NOT NULL
);


CREATE TABLE Partners (
  partner_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  commission_rate DECIMAL(8,2) DEFAULT 0.00,
  type ENUM('Hotel','Airbnb','TourAgency','Event','Other') NOT NULL,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE Payments (
  payment_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED NOT NULL,
  amount DECIMAL(8,2) NOT NULL,
  status ENUM('Pending','Paid','Failed','Refunded') NOT NULL DEFAULT 'Pending',
  method ENUM('Card','Online Transaction') NOT NULL,
  transaction_ref VARCHAR(255) NOT NULL UNIQUE,
  paid_time DATETIME DEFAULT NULL
);


CREATE TABLE Orders (
  order_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  special TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 = has special handling note',
  special_note TEXT DEFAULT NULL,
  service_type ENUM('Delivery','Storage') NOT NULL,
  order_details_json LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin CHECK (json_valid(order_details_json)),
  dropoff_time DATETIME NOT NULL,
  pickup_time DATETIME NOT NULL,
  pickup_location_id INT UNSIGNED DEFAULT NULL,
  dropoff_location_id INT UNSIGNED NOT NULL,
  order_status ENUM('Pending','Confirmed','Out-for-Delivery','Completed','Cancelled') NOT NULL DEFAULT 'Pending',
  promo_code VARCHAR(255) DEFAULT NULL,
  is_cancelled TINYINT(1) DEFAULT 0,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  modified_by INT UNSIGNED DEFAULT NULL,
  payment_id INT UNSIGNED DEFAULT NULL,
  partner_id BIGINT UNSIGNED DEFAULT NULL,

  FOREIGN KEY (user_id) REFERENCES Users(user_id),
  FOREIGN KEY (pickup_location_id) REFERENCES Locations(location_id),
  FOREIGN KEY (dropoff_location_id) REFERENCES Locations(location_id),
  FOREIGN KEY (promo_code) REFERENCES Promo(promo_code),
  FOREIGN KEY (modified_by) REFERENCES Admins(staff_id),
  FOREIGN KEY (payment_id) REFERENCES Payments(payment_id),
  FOREIGN KEY (partner_id) REFERENCES Partners(partner_id)
);


CREATE TABLE Travel_Documents (
  doc_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED NOT NULL,
  doc_type ENUM('Passport','Visa','Ticket','Insurance','Other') NOT NULL,
  file_name VARCHAR(255) NOT NULL,
  file_path VARCHAR(255) NOT NULL,
  uploaded_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  verified TINYINT(1) DEFAULT 0,
  notes TEXT DEFAULT NULL,
  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE
);


CREATE TABLE LuggageItems (
  item_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED NOT NULL,
  size ENUM('Small','Medium','Large','Oversized') NOT NULL,
  insured BOOLEAN NOT NULL DEFAULT 0,
  special_request TEXT DEFAULT NULL,
  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE
);


CREATE TABLE Delivery (
  delivery_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED NOT NULL,
  driver_id INT UNSIGNED NOT NULL,
  status ENUM('Pending','On Route','Delivered','Failed') NOT NULL DEFAULT 'Pending',
  completed_time DATETIME DEFAULT NULL,
  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE
);


CREATE TABLE Reviews (
  review_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED DEFAULT NULL,
  rating TINYINT CHECK (rating BETWEEN 1 AND 5),
  comment TEXT DEFAULT NULL,
  source ENUM('Google','Website','Others') NOT NULL DEFAULT 'Others',
  external_link VARCHAR(500) DEFAULT NULL,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE SET NULL
);


-- ============================================================================
-- MIGRATION HISTORY TABLE
-- ============================================================================
CREATE TABLE migrations (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  version VARCHAR(255) NOT NULL,
  class VARCHAR(255) NOT NULL,
  group VARCHAR(255) NOT NULL,
  namespace VARCHAR(255) NOT NULL,
  time INT UNSIGNED NOT NULL,
  batch INT UNSIGNED NOT NULL
);

-- ============================================================================
-- SEEDING SECTION
-- ============================================================================

-- SEED: Insert sample users
INSERT INTO Users (first_name, last_name, email, phone, social, social_num) VALUES
('John', 'Doe', 'john.doe@example.com', '+60168888888', 'MyKad', '123456789012'),
('Jane', 'Smith', 'jane.smith@example.com', '+60169999999', 'Passport', 'A12345678'),
('Ahmad', 'Hassan', 'ahmad.hassan@example.com', '+60167777777', 'MyKad', '123456780123'),
('Maria', 'Garcia', 'maria.garcia@example.com', '+60165555555', 'Passport', 'B98765432');

-- SEED: Insert sample admin users
INSERT INTO Admins (staff_name, password, email, role) VALUES
('Admin User', '$2y$10$admin_password_hash_here', 'admin@easesarawak.com', 'Admin'),
('Super Admin', '$2y$10$superadmin_password_hash_here', 'superadmin@easesarawak.com', 'Superadmin');

-- SEED: Insert sample locations
INSERT INTO Locations (name, category) VALUES
('Kuching International Airport', 'Airport'),
('Miri Airport', 'Airport'),
('Hilton Kuching', 'Hotel'),
('Riverside Shopping Mall', 'Shopping Mall'),
('Sarawak Cultural Village', 'Other'),
('Sandakan Airport', 'Airport');

-- SEED: Insert sample promo codes
INSERT INTO Promo (promo_code, discount_type, discount_value, start_date, end_date, created_by) VALUES
('PROMO2025', 'Percent', 10.00, '2025-01-01 00:00:00', '2025-12-31 23:59:59', 1),
('WELCOME50', 'Flat', 50.00, '2025-01-01 00:00:00', '2025-06-30 23:59:59', 1),
('NEWUSER', 'Percent', 15.00, '2025-11-01 00:00:00', '2025-11-30 23:59:59', 2);

-- SEED: Insert sample partners
INSERT INTO Partners (name, commission_rate, type) VALUES
('Sarawak Hotels Group', 5.50, 'Hotel'),
('Local Tour Operators', 8.00, 'TourAgency'),
('Adventure Airbnb', 6.00, 'Airbnb'),
('Event Management Co', 10.00, 'Event'),
('Express Delivery', 4.50, 'Other');

-- SEED: Insert sample orders (will reference existing users and locations)
INSERT INTO Orders (user_id, special, special_note, service_type, order_details_json, dropoff_time, pickup_time, pickup_location_id, dropoff_location_id, order_status, promo_code, payment_id, partner_id) VALUES
(1, 0, NULL, 'Delivery', '{"item_count": 2, "weight": "5kg"}', '2025-11-20 14:00:00', '2025-11-20 10:00:00', 1, 2, 'Pending', 'PROMO2025', NULL, 1),
(2, 1, 'Handle with care - Fragile items', 'Storage', '{"item_count": 5, "weight": "15kg"}', '2025-11-25 16:30:00', '2025-11-20 11:00:00', 3, 4, 'Confirmed', NULL, NULL, 2),
(3, 0, NULL, 'Delivery', '{"item_count": 1, "weight": "10kg"}', '2025-11-22 12:00:00', '2025-11-22 09:00:00', 2, 5, 'Out-for-Delivery', 'WELCOME50', NULL, 5),
(4, 1, 'Leave at reception desk', 'Delivery', '{"item_count": 3, "weight": "8kg"}', '2025-11-23 15:00:00', '2025-11-23 10:00:00', 5, 1, 'Completed', 'NEWUSER', NULL, 1);

-- SEED: Insert sample travel documents
INSERT INTO Travel_Documents (order_id, doc_type, file_name, file_path, verified, notes) VALUES
(1, 'Passport', 'john_doe_passport.pdf', '/uploads/documents/john_doe_passport.pdf', 1, 'Verified and valid'),
(2, 'Visa', 'jane_smith_visa.pdf', '/uploads/documents/jane_smith_visa.pdf', 0, 'Pending verification'),
(3, 'Ticket', 'ahmad_ticket.pdf', '/uploads/documents/ahmad_ticket.pdf', 1, 'Flight ticket verified'),
(4, 'Insurance', 'maria_insurance.pdf', '/uploads/documents/maria_insurance.pdf', 1, 'Insurance coverage confirmed');

-- SEED: Insert sample luggage items
INSERT INTO LuggageItems (order_id, size, insured, special_request) VALUES
(1, 'Medium', 1, NULL),
(1, 'Small', 0, NULL),
(2, 'Large', 1, 'This contains electronics - handle carefully'),
(2, 'Oversized', 1, 'Fragile - musical instrument inside'),
(3, 'Large', 0, 'Winter clothing'),
(4, 'Medium', 1, NULL);

-- SEED: Insert sample reviews
INSERT INTO Reviews (order_id, rating, comment, source, external_link) VALUES
(3, 5, 'Excellent service! Delivery was on time and items were safe.', 'Website', NULL),
(4, 4, 'Good service, could improve on communication.', 'Google', 'https://google.com/review/example1'),
(NULL, 5, 'EASE Sarawak is the best luggage service in Sarawak!', 'Others', NULL);

-- SEED: Insert sample payments
INSERT INTO Payments (order_id, amount, status, method, transaction_ref, paid_time) VALUES
(1, 150.00, 'Paid', 'Card', 'TXN20251120001', '2025-11-20 10:15:00'),
(2, 250.00, 'Pending', 'Online Transaction', 'TXN20251121001', NULL),
(3, 200.00, 'Paid', 'Card', 'TXN20251122001', '2025-11-22 09:30:00'),
(4, 180.00, 'Paid', 'Card', 'TXN20251123001', '2025-11-23 10:45:00');

-- SEED: Update orders with payment references (now that payments exist)
UPDATE Orders SET payment_id = 1 WHERE order_id = 1;
UPDATE Orders SET payment_id = 2 WHERE order_id = 2;
UPDATE Orders SET payment_id = 3 WHERE order_id = 3;
UPDATE Orders SET payment_id = 4 WHERE order_id = 4;

-- SEED: Insert sample deliveries
INSERT INTO Delivery (order_id, driver_id, status, completed_time) VALUES
(1, 1001, 'Delivered', '2025-11-20 14:30:00'),
(2, 1002, 'Pending', NULL),
(3, 1003, 'On Route', NULL),
(4, 1001, 'Delivered', '2025-11-23 15:45:00');
