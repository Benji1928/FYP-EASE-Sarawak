CREATE TABLE Users (
  user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(255) NOT NULL,
  last_name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  phone VARCHAR(30) NOT NULL,
  social VARCHAR(50),
  social_num VARCHAR(50),
  nationality VARCHAR(100),
  customer_type VARCHAR(50),
  customer_segment VARCHAR(50),
  source_of_booking VARCHAR(100),
  how_heard_about_us TEXT,
  is_active BOOLEAN DEFAULT TRUE,
  INDEX (email),
  INDEX (customer_type),
  INDEX (nationality)
);

CREATE TABLE User_Social_Contacts (
  social_contact_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  contact_platform VARCHAR(50) NOT NULL,
  contact_handle VARCHAR(255) NOT NULL,
  is_primary BOOLEAN DEFAULT FALSE,
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

CREATE TABLE Admins (
  staff_id INT AUTO_INCREMENT PRIMARY KEY,
  staff_name VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  role VARCHAR(50) NOT NULL DEFAULT 'Admin',
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  modified_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX (role)
);

CREATE TABLE Promo (
  promo_code VARCHAR(255) PRIMARY KEY,
  discount_type VARCHAR(20) NOT NULL,
  discount_value DECIMAL(8,2) NOT NULL,
  start_date DATETIME NOT NULL,
  end_date DATETIME NOT NULL,
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  created_by INT NOT NULL,
  FOREIGN KEY (created_by) REFERENCES Admins(staff_id)
);

CREATE TABLE Locations (
  location_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  category VARCHAR(50) NOT NULL,
  address TEXT,
  total_capacity INT,
  current_occupancy INT DEFAULT 0,
  is_active BOOLEAN DEFAULT TRUE,
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX (category),
  INDEX (is_active)
);

CREATE TABLE Partners (
  partner_id BIGINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  commission_rate DECIMAL(8,2) DEFAULT 0.00,
  type VARCHAR(50) NOT NULL,
  contact_person VARCHAR(255),
  contact_email VARCHAR(255),
  contact_phone VARCHAR(20),
  contract_start_date DATE,
  contract_end_date DATE,
  is_active BOOLEAN DEFAULT TRUE,
  address TEXT,
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX (type),
  INDEX (is_active)
);

CREATE TABLE Payments (
  payment_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  amount DECIMAL(8,2) NOT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'Pending',
  method VARCHAR(50) NOT NULL,
  transaction_ref VARCHAR(255) NOT NULL UNIQUE,
  paid_time DATETIME,
  currency VARCHAR(3) DEFAULT 'MYR',
  refund_reason TEXT,
  refund_time DATETIME,
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX (status),
  INDEX (transaction_ref)
);

CREATE TABLE Orders (
  order_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  special BOOLEAN DEFAULT FALSE,
  special_note TEXT,
  service_type VARCHAR(50) NOT NULL,
  order_details_json LONGTEXT,
  dropoff_time DATETIME NOT NULL,
  pickup_time DATETIME NOT NULL,
  requested_delivery_time DATETIME,
  pickup_location_id INT,
  dropoff_location_id INT NOT NULL,
  pickup_location_type VARCHAR(50),
  dropoff_location_type VARCHAR(50),
  order_status VARCHAR(50) NOT NULL DEFAULT 'Pending',
  promo_code VARCHAR(255),
  is_cancelled BOOLEAN DEFAULT FALSE,
  cancellation_reason TEXT,
  cancellation_time DATETIME,
  base_price DECIMAL(10,2),
  insurance_fee DECIMAL(10,2) DEFAULT 0.00,
  delivery_fee DECIMAL(10,2) DEFAULT 0.00,
  discount_amount DECIMAL(10,2) DEFAULT 0.00,
  total_amount DECIMAL(10,2),
  number_of_bags INT DEFAULT 1,
  has_oversized_bags BOOLEAN DEFAULT FALSE,
  has_special_items BOOLEAN DEFAULT FALSE,
  booking_channel VARCHAR(50) DEFAULT 'direct',
  booking_source VARCHAR(100),
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  modified_by INT,
  payment_id INT,
  partner_id BIGINT,
  FOREIGN KEY (user_id) REFERENCES Users(user_id),
  FOREIGN KEY (pickup_location_id) REFERENCES Locations(location_id),
  FOREIGN KEY (dropoff_location_id) REFERENCES Locations(location_id),
  FOREIGN KEY (promo_code) REFERENCES Promo(promo_code),
  FOREIGN KEY (modified_by) REFERENCES Admins(staff_id),
  FOREIGN KEY (payment_id) REFERENCES Payments(payment_id),
  FOREIGN KEY (partner_id) REFERENCES Partners(partner_id),
  INDEX (user_id),
  INDEX (order_status),
  INDEX (service_type),
  INDEX (created_date),
  INDEX (pickup_time),
  INDEX (booking_channel)
);

CREATE TABLE Travel_Documents (
  doc_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  doc_type VARCHAR(50) NOT NULL,
  file_name VARCHAR(255) NOT NULL,
  file_path VARCHAR(255) NOT NULL,
  uploaded_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  verified BOOLEAN DEFAULT FALSE,
  verified_by INT,
  verified_date DATETIME,
  notes TEXT,
  FOREIGN KEY (order_id) REFERENCES Orders(order_id),
  FOREIGN KEY (verified_by) REFERENCES Admins(staff_id)
);

CREATE TABLE LuggageItems (
  item_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  size VARCHAR(20) NOT NULL,
  insured BOOLEAN DEFAULT FALSE,
  insurance_value DECIMAL(10,2),
  special_request TEXT,
  FOREIGN KEY (order_id) REFERENCES Orders(order_id)
);

CREATE TABLE Delivery (
  delivery_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  driver_id INT NOT NULL,
  status VARCHAR(50) NOT NULL DEFAULT 'Pending',
  assigned_at DATETIME,
  pickup_started_at DATETIME,
  pickup_completed_at DATETIME,
  delivery_started_at DATETIME,
  completed_time DATETIME,
  duration_minutes INT,
  distance_km DECIMAL(8,2),
  on_time BOOLEAN,
  delay_minutes INT DEFAULT 0,
  delivery_notes TEXT,
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (order_id) REFERENCES Orders(order_id),
  FOREIGN KEY (driver_id) REFERENCES Admins(staff_id),
  INDEX (driver_id),
  INDEX (status)
);

CREATE TABLE Reviews (
  review_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  user_id INT,
  rating INT,
  comment TEXT,
  source VARCHAR(50) DEFAULT 'Others',
  external_link VARCHAR(500),
  response_text TEXT,
  comment_date DATETIME,
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (order_id) REFERENCES Orders(order_id),
  FOREIGN KEY (user_id) REFERENCES Users(user_id),
  INDEX (rating),
  INDEX (source)
);

CREATE TABLE Storage_Tracking (
  tracking_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  location_id INT,
  check_in_time DATETIME,
  storage_start_time DATETIME,
  storage_end_time DATETIME,
  pickup_time DATETIME,
  checked_in_by INT,
  retrieved_by INT,
  storage_notes TEXT,
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (order_id) REFERENCES Orders(order_id),
  FOREIGN KEY (location_id) REFERENCES Locations(location_id),
  FOREIGN KEY (checked_in_by) REFERENCES Admins(staff_id),
  FOREIGN KEY (retrieved_by) REFERENCES Admins(staff_id),
  INDEX (order_id),
  INDEX (location_id)
);

CREATE TABLE Staff_Performance (
  performance_id INT AUTO_INCREMENT PRIMARY KEY,
  staff_id INT NOT NULL,
  performance_date DATE NOT NULL,
  deliveries_completed INT DEFAULT 0,
  pickups_completed INT DEFAULT 0,
  average_delivery_time_minutes INT,
  on_time_rate DECIMAL(5,2),
  bags_processed INT DEFAULT 0,
  incidents_reported INT DEFAULT 0,
  shift_start_time DATETIME,
  shift_end_time DATETIME,
  hours_worked DECIMAL(5,2),
  notes TEXT,
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (staff_id) REFERENCES Admins(staff_id),
  INDEX (staff_id, performance_date)
);

CREATE TABLE Revenue_Records (
  revenue_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  transaction_date DATE NOT NULL,
  service_revenue DECIMAL(10,2) DEFAULT 0.00,
  delivery_revenue DECIMAL(10,2) DEFAULT 0.00,
  insurance_revenue DECIMAL(10,2) DEFAULT 0.00,
  partner_commission DECIMAL(10,2) DEFAULT 0.00,
  net_revenue DECIMAL(10,2) NOT NULL,
  revenue_channel VARCHAR(50),
  service_type VARCHAR(50),
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (order_id) REFERENCES Orders(order_id),
  INDEX (transaction_date),
  INDEX (revenue_channel)
);

CREATE TABLE Operational_Costs (
  cost_id INT AUTO_INCREMENT PRIMARY KEY,
  cost_date DATE NOT NULL,
  cost_category VARCHAR(50) NOT NULL,
  cost_subcategory VARCHAR(100),
  amount DECIMAL(10,2) NOT NULL,
  description TEXT,
  is_recurring BOOLEAN DEFAULT FALSE,
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX (cost_date),
  INDEX (cost_category)
);

CREATE TABLE Partner_Performance (
  performance_id INT AUTO_INCREMENT PRIMARY KEY,
  partner_id BIGINT NOT NULL,
  period_start DATE NOT NULL,
  period_end DATE NOT NULL,
  total_bookings INT DEFAULT 0,
  completed_bookings INT DEFAULT 0,
  cancelled_bookings INT DEFAULT 0,
  total_revenue DECIMAL(10,2) DEFAULT 0.00,
  commission_paid DECIMAL(10,2) DEFAULT 0.00,
  average_rating DECIMAL(3,2),
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (partner_id) REFERENCES Partners(partner_id),
  INDEX (partner_id, period_start)
);

CREATE TABLE Partner_Feedback (
  feedback_id INT AUTO_INCREMENT PRIMARY KEY,
  partner_id BIGINT NOT NULL,
  feedback_date DATE NOT NULL,
  feedback_type VARCHAR(20) NOT NULL,
  feedback_text TEXT,
  resolved BOOLEAN DEFAULT FALSE,
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (partner_id) REFERENCES Partners(partner_id)
);

CREATE TABLE Marketing_Campaigns (
  campaign_id INT AUTO_INCREMENT PRIMARY KEY,
  campaign_name VARCHAR(255) NOT NULL,
  campaign_type VARCHAR(50) NOT NULL,
  start_date DATE,
  end_date DATE,
  budget DECIMAL(10,2),
  total_spend DECIMAL(10,2) DEFAULT 0.00,
  impressions INT DEFAULT 0,
  clicks INT DEFAULT 0,
  conversions INT DEFAULT 0,
  revenue_generated DECIMAL(10,2) DEFAULT 0.00,
  is_active BOOLEAN DEFAULT TRUE,
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX (start_date, end_date)
);

CREATE TABLE Tourist_Arrivals_Data (
  arrival_id INT AUTO_INCREMENT PRIMARY KEY,
  period_start DATE NOT NULL,
  period_end DATE NOT NULL,
  location VARCHAR(100) DEFAULT 'Kuching',
  total_arrivals INT,
  international_arrivals INT,
  domestic_arrivals INT,
  data_source VARCHAR(255),
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE (period_start, location),
  INDEX (period_start)
);

CREATE TABLE Flight_Schedules (
  schedule_id INT AUTO_INCREMENT PRIMARY KEY,
  airport_code VARCHAR(10) DEFAULT 'KCH',
  flight_number VARCHAR(20) NOT NULL,
  airline VARCHAR(100),
  flight_type VARCHAR(20) NOT NULL,
  origin_destination VARCHAR(100),
  scheduled_time DATETIME NOT NULL,
  actual_time DATETIME,
  status VARCHAR(50) DEFAULT 'scheduled',
  passenger_capacity INT,
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE (flight_number, scheduled_time),
  INDEX (scheduled_time),
  INDEX (flight_type)
);

CREATE TABLE Hotel_Occupancy_Stats (
  occupancy_id INT AUTO_INCREMENT PRIMARY KEY,
  period_date DATE NOT NULL,
  location VARCHAR(100) DEFAULT 'Kuching',
  average_occupancy_rate DECIMAL(5,2),
  total_rooms_available INT,
  rooms_occupied INT,
  data_source VARCHAR(255),
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX (period_date)
);

CREATE TABLE Local_Events (
  event_id INT AUTO_INCREMENT PRIMARY KEY,
  event_name VARCHAR(255) NOT NULL,
  event_type VARCHAR(100),
  event_start_date DATE NOT NULL,
  event_end_date DATE NOT NULL,
  location VARCHAR(255),
  expected_attendance INT,
  impact_level VARCHAR(20) DEFAULT 'medium',
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX (event_start_date, event_end_date)
);

CREATE TABLE Traffic_Route_Data (
  traffic_id INT AUTO_INCREMENT PRIMARY KEY,
  route_name VARCHAR(255),
  origin_location VARCHAR(255),
  destination_location VARCHAR(255),
  log_datetime DATETIME NOT NULL,
  average_travel_time_minutes INT,
  distance_km DECIMAL(8,2),
  traffic_condition VARCHAR(20) DEFAULT 'moderate',
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX (log_datetime)
);

CREATE TABLE Incidents (
  incident_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  incident_type VARCHAR(50) NOT NULL,
  incident_date DATETIME NOT NULL,
  incident_location VARCHAR(255),
  severity VARCHAR(20) DEFAULT 'medium',
  description TEXT NOT NULL,
  cause TEXT,
  reported_by_user_id INT,
  reported_by_staff_id INT,
  status VARCHAR(20) DEFAULT 'reported',
  resolution_notes TEXT,
  resolved_date DATETIME,
  estimated_cost DECIMAL(10,2),
  actual_cost DECIMAL(10,2),
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (order_id) REFERENCES Orders(order_id),
  FOREIGN KEY (reported_by_user_id) REFERENCES Users(user_id),
  FOREIGN KEY (reported_by_staff_id) REFERENCES Admins(staff_id),
  INDEX (incident_type),
  INDEX (incident_date),
  INDEX (status)
);

CREATE TABLE Insurance_Claims (
  claim_id INT AUTO_INCREMENT PRIMARY KEY,
  incident_id INT,
  order_id INT,
  user_id INT,
  claim_reference VARCHAR(100) UNIQUE,
  claim_date DATE NOT NULL,
  claim_amount DECIMAL(10,2) NOT NULL,
  claim_status VARCHAR(20) DEFAULT 'submitted',
  insurance_provider VARCHAR(255),
  policy_number VARCHAR(100),
  coverage_type VARCHAR(100),
  approved_amount DECIMAL(10,2),
  payout_date DATE,
  payout_reference VARCHAR(100),
  supporting_documents TEXT,
  notes TEXT,
  created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (incident_id) REFERENCES Incidents(incident_id),
  FOREIGN KEY (order_id) REFERENCES Orders(order_id),
  FOREIGN KEY (user_id) REFERENCES Users(user_id),
  INDEX (claim_status)
);