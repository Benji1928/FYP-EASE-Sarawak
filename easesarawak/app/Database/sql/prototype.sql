-- ============================================================================
-- EASE LUGGAGE SERVICES - INTEGRATED DATABASE SCHEMA ; Name: easesarawak
-- ============================================================================
-- Core Tables
-- ============================================================================

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
  lifetime_value DECIMAL(10,2) DEFAULT 0.00,
  customer_acquisition_cost DECIMAL(10,2) DEFAULT NULL,
  is_active BOOLEAN DEFAULT TRUE,
  
  INDEX idx_email (email),
  INDEX idx_customer_type (customer_type),
  INDEX idx_nationality (nationality)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE User_Social_Contacts (
  social_contact_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  platform VARCHAR(50) NOT NULL COMMENT 'whatsapp, wechat, line, telegram',
  contact_handle VARCHAR(255) NOT NULL,
  is_primary BOOLEAN DEFAULT FALSE,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE Admins (
  staff_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  staff_name VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  role ENUM('Admin','Superadmin','Driver','Storage_Handler','Customer_Service') NOT NULL DEFAULT 'Admin',
  employment_type ENUM('full_time','part_time','contractor') DEFAULT 'full_time',
  hire_date DATE DEFAULT NULL,
  is_active BOOLEAN DEFAULT TRUE,
  
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  modified_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  INDEX idx_role (role),
  INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE Promo (
  promo_code VARCHAR(255) PRIMARY KEY,
  discount_type ENUM('Flat','Percent') NOT NULL,
  discount_value DECIMAL(8,2) NOT NULL,
  start_date DATETIME NOT NULL,
  end_date DATETIME NOT NULL,
  usage_limit INT DEFAULT NULL COMMENT 'NULL = unlimited',
  times_used INT DEFAULT 0,
  is_active BOOLEAN DEFAULT TRUE,
  
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  created_by INT UNSIGNED NOT NULL COMMENT 'Tracks which admin created the promo',
  FOREIGN KEY (created_by) REFERENCES Admins(staff_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE Locations (
  location_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  category ENUM('Airport','Hotel','Shopping Mall','Hub','Partner_Location','Other') NOT NULL,
  address TEXT DEFAULT NULL,
  total_capacity INT DEFAULT NULL COMMENT 'number of bags for storage locations',
  current_occupancy INT DEFAULT 0,
  is_active BOOLEAN DEFAULT TRUE,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
  INDEX idx_category (category),
  INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


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


CREATE TABLE Payments (
  payment_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED NOT NULL,
  amount DECIMAL(8,2) NOT NULL,
  status ENUM('Pending','Paid','Failed','Refunded') NOT NULL DEFAULT 'Pending',
  method ENUM('Card','Online Transaction','Cash','Bank_Transfer','E-Wallet') NOT NULL,
  transaction_ref VARCHAR(255) NOT NULL UNIQUE,
  paid_time DATETIME DEFAULT NULL,
  
  -- ENHANCED: Added payment tracking
  payment_gateway VARCHAR(50) DEFAULT NULL,
  invoice_number VARCHAR(100) DEFAULT NULL,
  currency VARCHAR(3) DEFAULT 'MYR',
  refund_reason TEXT DEFAULT NULL,
  refund_time DATETIME DEFAULT NULL,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
  INDEX idx_status (status),
  INDEX idx_transaction_ref (transaction_ref)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


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


CREATE TABLE LuggageItems (
  item_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED NOT NULL,
  size ENUM('Small','Medium','Large','Oversized') NOT NULL,
  insured BOOLEAN NOT NULL DEFAULT 0,
  insurance_value DECIMAL(10,2) DEFAULT NULL,
  special_request TEXT DEFAULT NULL,
  
  -- ENHANCED: Item tracking
  item_tag VARCHAR(100) DEFAULT NULL COMMENT 'Physical tag/barcode number',
  weight_kg DECIMAL(5,2) DEFAULT NULL,
  
  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE Delivery (
  delivery_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED NOT NULL,
  driver_id INT UNSIGNED NOT NULL,
  vehicle_id INT UNSIGNED DEFAULT NULL,
  status ENUM('Pending','Assigned','On Route','Delivered','Failed') NOT NULL DEFAULT 'Pending',
  
  -- ENHANCED: Detailed tracking
  assigned_at DATETIME DEFAULT NULL,
  pickup_started_at DATETIME DEFAULT NULL,
  pickup_completed_at DATETIME DEFAULT NULL,
  delivery_started_at DATETIME DEFAULT NULL,
  completed_time DATETIME DEFAULT NULL,
  
  -- Performance metrics
  estimated_duration_minutes INT DEFAULT NULL,
  actual_duration_minutes INT DEFAULT NULL,
  distance_km DECIMAL(8,2) DEFAULT NULL,
  on_time BOOLEAN DEFAULT NULL,
  delay_minutes INT DEFAULT 0,
  
  delivery_notes TEXT DEFAULT NULL,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE,
  FOREIGN KEY (driver_id) REFERENCES Admins(staff_id),
  
  INDEX idx_driver (driver_id),
  INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE Reviews (
  review_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED DEFAULT NULL,
  user_id INT UNSIGNED DEFAULT NULL,
  rating TINYINT CHECK (rating BETWEEN 1 AND 5),
  comment TEXT DEFAULT NULL,
  source ENUM('Google','Website','Facebook','Others') NOT NULL DEFAULT 'Others',
  external_link VARCHAR(500) DEFAULT NULL,
  
  -- ENHANCED: Response tracking
  response_text TEXT DEFAULT NULL,
  response_date DATETIME DEFAULT NULL,
  is_public BOOLEAN DEFAULT TRUE,
  
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE SET NULL,
  FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE SET NULL,
  
  INDEX idx_rating (rating),
  INDEX idx_source (source)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================================
-- Operations Tables
-- ============================================================================

-- Storage tracking for bags in storage
CREATE TABLE Storage_Tracking (
  tracking_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED NOT NULL,
  location_id INT UNSIGNED DEFAULT NULL,
  
  -- Time stamps
  check_in_time DATETIME DEFAULT NULL,
  storage_start_time DATETIME DEFAULT NULL,
  storage_end_time DATETIME DEFAULT NULL,
  pickup_time DATETIME DEFAULT NULL,
  
  -- Staff handling
  checked_in_by INT UNSIGNED DEFAULT NULL,
  retrieved_by INT UNSIGNED DEFAULT NULL,
  
  storage_notes TEXT DEFAULT NULL,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE,
  FOREIGN KEY (location_id) REFERENCES Locations(location_id),
  FOREIGN KEY (checked_in_by) REFERENCES Admins(staff_id),
  FOREIGN KEY (retrieved_by) REFERENCES Admins(staff_id),
  
  INDEX idx_order (order_id),
  INDEX idx_location (location_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Vehicle management
CREATE TABLE Vehicles (
  vehicle_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  vehicle_type ENUM('van','car','motorcycle','truck') NOT NULL,
  license_plate VARCHAR(20) UNIQUE NOT NULL,
  capacity INT DEFAULT NULL COMMENT 'number of bags',
  current_status ENUM('available','in_use','maintenance','retired') DEFAULT 'available',
  last_maintenance_date DATE DEFAULT NULL,
  next_maintenance_date DATE DEFAULT NULL,
  is_active BOOLEAN DEFAULT TRUE,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
  INDEX idx_status (current_status),
  INDEX idx_license (license_plate)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add foreign key to Delivery table
ALTER TABLE Delivery ADD FOREIGN KEY (vehicle_id) REFERENCES Vehicles(vehicle_id);


-- Vehicle usage tracking
CREATE TABLE Vehicle_Usage (
  usage_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  vehicle_id INT UNSIGNED NOT NULL,
  usage_date DATE NOT NULL,
  trips_completed INT DEFAULT 0,
  total_distance_km DECIMAL(8,2) DEFAULT 0.00,
  fuel_cost DECIMAL(10,2) DEFAULT 0.00,
  maintenance_cost DECIMAL(10,2) DEFAULT 0.00,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (vehicle_id) REFERENCES Vehicles(vehicle_id) ON DELETE CASCADE,
  
  INDEX idx_vehicle_date (vehicle_id, usage_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Staff performance tracking
CREATE TABLE Staff_Performance (
  performance_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  staff_id INT UNSIGNED NOT NULL,
  performance_date DATE NOT NULL,
  
  -- For drivers
  deliveries_completed INT DEFAULT 0,
  pickups_completed INT DEFAULT 0,
  average_delivery_time_minutes INT DEFAULT NULL,
  on_time_rate DECIMAL(5,2) DEFAULT NULL,
  
  -- For storage handlers
  bags_processed INT DEFAULT 0,
  incidents_reported INT DEFAULT 0,
  
  -- General
  shift_start_time DATETIME DEFAULT NULL,
  shift_end_time DATETIME DEFAULT NULL,
  hours_worked DECIMAL(5,2) DEFAULT NULL,
  
  notes TEXT DEFAULT NULL,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (staff_id) REFERENCES Admins(staff_id) ON DELETE CASCADE,
  
  INDEX idx_staff_date (staff_id, performance_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================================
-- Finance Tables
-- ============================================================================

-- Revenue tracking
CREATE TABLE Revenue_Records (
  revenue_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED DEFAULT NULL,
  transaction_date DATE NOT NULL,
  
  -- Revenue breakdown
  service_revenue DECIMAL(10,2) DEFAULT 0.00,
  delivery_revenue DECIMAL(10,2) DEFAULT 0.00,
  insurance_revenue DECIMAL(10,2) DEFAULT 0.00,
  partner_commission DECIMAL(10,2) DEFAULT 0.00,
  net_revenue DECIMAL(10,2) NOT NULL,
  
  -- Classification
  revenue_channel VARCHAR(50) DEFAULT NULL COMMENT 'direct, partner',
  service_type VARCHAR(50) DEFAULT NULL,
  
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE SET NULL,
  
  INDEX idx_date (transaction_date),
  INDEX idx_channel (revenue_channel)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Operational costs
CREATE TABLE Operational_Costs (
  cost_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  cost_date DATE NOT NULL,
  cost_category ENUM('hub_operation','logistics','marketing','staff','maintenance','utilities','other') NOT NULL,
  cost_subcategory VARCHAR(100) DEFAULT NULL,
  amount DECIMAL(10,2) NOT NULL,
  description TEXT DEFAULT NULL,
  is_recurring BOOLEAN DEFAULT FALSE,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
  INDEX idx_date (cost_date),
  INDEX idx_category (cost_category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Partner performance tracking
CREATE TABLE Partner_Performance (
  performance_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  partner_id BIGINT UNSIGNED NOT NULL,
  period_start DATE NOT NULL,
  period_end DATE NOT NULL,
  total_bookings INT DEFAULT 0,
  completed_bookings INT DEFAULT 0,
  cancelled_bookings INT DEFAULT 0,
  total_revenue DECIMAL(10,2) DEFAULT 0.00,
  commission_paid DECIMAL(10,2) DEFAULT 0.00,
  average_rating DECIMAL(3,2) DEFAULT NULL,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (partner_id) REFERENCES Partners(partner_id) ON DELETE CASCADE,
  
  INDEX idx_partner_period (partner_id, period_start)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Partner feedback
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


-- Marketing campaigns
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


-- Customer journey tracking
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


-- ============================================================================
-- External Data Tables
-- ============================================================================

-- Tourist arrivals data
CREATE TABLE Tourist_Arrivals_Data (
  arrival_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  period_start DATE NOT NULL,
  period_end DATE NOT NULL,
  location VARCHAR(100) NOT NULL DEFAULT 'Kuching',
  total_arrivals INT DEFAULT NULL,
  international_arrivals INT DEFAULT NULL,
  domestic_arrivals INT DEFAULT NULL,
  data_source VARCHAR(255) DEFAULT NULL,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
  UNIQUE KEY unique_period_location (period_start, location),
  INDEX idx_period (period_start)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Flight schedules
CREATE TABLE Flight_Schedules (
  schedule_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  airport_code VARCHAR(10) DEFAULT 'KCH',
  flight_number VARCHAR(20) NOT NULL,
  airline VARCHAR(100) DEFAULT NULL,
  flight_type ENUM('arrival','departure') NOT NULL,
  origin_destination VARCHAR(100) DEFAULT NULL,
  scheduled_time DATETIME NOT NULL,
  actual_time DATETIME DEFAULT NULL,
  status VARCHAR(50) DEFAULT 'scheduled',
  passenger_capacity INT DEFAULT NULL,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
  UNIQUE KEY unique_flight_time (flight_number, scheduled_time),
  INDEX idx_scheduled_time (scheduled_time),
  INDEX idx_flight_type (flight_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Hotel occupancy statistics
CREATE TABLE Hotel_Occupancy_Stats (
  occupancy_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  period_date DATE NOT NULL,
  location VARCHAR(100) DEFAULT 'Kuching',
  average_occupancy_rate DECIMAL(5,2) DEFAULT NULL,
  total_rooms_available INT DEFAULT NULL,
  rooms_occupied INT DEFAULT NULL,
  data_source VARCHAR(255) DEFAULT NULL,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
  INDEX idx_date (period_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Local events
CREATE TABLE Local_Events (
  event_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  event_name VARCHAR(255) NOT NULL,
  event_type VARCHAR(100) DEFAULT NULL COMMENT 'festival, conference, sports, concert',
  event_start_date DATE NOT NULL,
  event_end_date DATE NOT NULL,
  location VARCHAR(255) DEFAULT NULL,
  expected_attendance INT DEFAULT NULL,
  impact_level ENUM('low','medium','high') DEFAULT 'medium',
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
  INDEX idx_dates (event_start_date, event_end_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Traffic/route data
CREATE TABLE Traffic_Route_Data (
  traffic_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  route_name VARCHAR(255) DEFAULT NULL,
  origin_location VARCHAR(255) DEFAULT NULL,
  destination_location VARCHAR(255) DEFAULT NULL,
  log_datetime DATETIME NOT NULL,
  average_travel_time_minutes INT DEFAULT NULL,
  distance_km DECIMAL(8,2) DEFAULT NULL,
  traffic_condition ENUM('light','moderate','heavy','severe') DEFAULT 'moderate',
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
  INDEX idx_datetime (log_datetime)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================================
-- Risk Management Tables
-- ============================================================================

-- Incidents
CREATE TABLE Incidents (
  incident_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED DEFAULT NULL,
  incident_type ENUM('lost','damaged','delayed','theft','security_breach','other') NOT NULL,
  incident_date DATETIME NOT NULL,
  incident_location VARCHAR(255) DEFAULT NULL,
  
  -- Details
  severity ENUM('low','medium','high','critical') DEFAULT 'medium',
  description TEXT NOT NULL,
  cause TEXT DEFAULT NULL,
  
  -- People involved
  reported_by_user_id INT UNSIGNED DEFAULT NULL,
  reported_by_staff_id INT UNSIGNED DEFAULT NULL,
  
  -- Resolution
  status ENUM('reported','investigating','resolved','closed') DEFAULT 'reported',
  resolution_notes TEXT DEFAULT NULL,
  resolved_date DATETIME DEFAULT NULL,
  
  -- Financial impact
  estimated_cost DECIMAL(10,2) DEFAULT NULL,
  actual_cost DECIMAL(10,2) DEFAULT NULL,
  
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE SET NULL,
  FOREIGN KEY (reported_by_user_id) REFERENCES Users(user_id),
  FOREIGN KEY (reported_by_staff_id) REFERENCES Admins(staff_id),
  
  INDEX idx_type (incident_type),
  INDEX idx_date (incident_date),
  INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Insurance claims
CREATE TABLE Insurance_Claims (
  claim_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  incident_id INT UNSIGNED DEFAULT NULL,
  order_id INT UNSIGNED DEFAULT NULL,
  user_id INT UNSIGNED DEFAULT NULL,
  
  claim_reference VARCHAR(100) UNIQUE,
  claim_date DATE NOT NULL,
  claim_amount DECIMAL(10,2) NOT NULL,
  claim_status ENUM('submitted','under_review','approved','paid','rejected') DEFAULT 'submitted',
  
  -- Insurance details
  insurance_provider VARCHAR(255) DEFAULT NULL,
  policy_number VARCHAR(100) DEFAULT NULL,
  coverage_type VARCHAR(100) DEFAULT NULL,
  
  -- Payout
  approved_amount DECIMAL(10,2) DEFAULT NULL,
  payout_date DATE DEFAULT NULL,
  payout_reference VARCHAR(100) DEFAULT NULL,
  
  -- Documentation
  supporting_documents TEXT DEFAULT NULL,
  notes TEXT DEFAULT NULL,
  
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (incident_id) REFERENCES Incidents(incident_id) ON DELETE CASCADE,
  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE SET NULL,
  FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE SET NULL,
  
  INDEX idx_status (claim_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Security logs
CREATE TABLE Security_Logs (
  log_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  log_type VARCHAR(50) NOT NULL COMMENT 'access, unusual_activity, delivery_issue, system_alert',
  severity ENUM('info','warning','critical') DEFAULT 'info',
  
  -- Location and time
  location_id INT UNSIGNED DEFAULT NULL,
  log_datetime DATETIME NOT NULL,
  
  -- Details
  description TEXT NOT NULL,
  staff_id INT UNSIGNED DEFAULT NULL,
  action_taken TEXT DEFAULT NULL,
  
  -- Follow-up
  requires_followup BOOLEAN DEFAULT FALSE,
  followup_status VARCHAR(50) DEFAULT NULL,
  resolved_at DATETIME DEFAULT NULL,
  
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (location_id) REFERENCES Locations(location_id),
  FOREIGN KEY (staff_id) REFERENCES Admins(staff_id),
  
  INDEX idx_datetime (log_datetime),
  INDEX idx_type (log_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================================
-- SECTION 6: ANALYTICS VIEWS
-- ============================================================================

-- Daily operations summary
CREATE OR REPLACE VIEW daily_operations_summary AS
SELECT 
    DATE(o.pickup_time) as operation_date,
    COUNT(DISTINCT o.order_id) as total_orders,
    COUNT(DISTINCT CASE WHEN o.service_type = 'Storage' THEN o.order_id END) as storage_orders,
    COUNT(DISTINCT CASE WHEN o.service_type IN ('Delivery', 'Storage_Delivery') THEN o.order_id END) as delivery_orders,
    SUM(o.number_of_bags) as total_bags_processed,
    COUNT(DISTINCT CASE WHEN o.order_status = 'Completed' THEN o.order_id END) as completed_orders,
    COUNT(DISTINCT CASE WHEN o.order_status = 'Cancelled' THEN o.order_id END) as cancelled_orders,
    COALESCE(AVG(CASE WHEN d.on_time = 1 THEN 1 ELSE 0 END) * 100, 0) as on_time_delivery_rate,
    SUM(o.total_amount) as daily_revenue
FROM Orders o
LEFT JOIN Delivery d ON o.order_id = d.order_id
GROUP BY DATE(o.pickup_time);


-- Customer lifetime value
CREATE OR REPLACE VIEW customer_lifetime_value AS
SELECT 
    u.user_id,
    u.first_name,
    u.last_name,
    u.email,
    u.customer_type,
    COUNT(o.order_id) as total_orders,
    SUM(o.total_amount) as total_spent,
    AVG(o.total_amount) as average_order_value,
    MIN(o.created_date) as first_order_date,
    MAX(o.created_date) as last_order_date,
    AVG(r.rating) as average_rating
FROM Users u
LEFT JOIN Orders o ON u.user_id = o.user_id
LEFT JOIN Reviews r ON u.user_id = r.user_id
GROUP BY u.user_id, u.first_name, u.last_name, u.email, u.customer_type;


-- Monthly revenue analysis
CREATE OR REPLACE VIEW monthly_revenue_analysis AS
SELECT 
    DATE_FORMAT(transaction_date, '%Y-%m') as month,
    SUM(service_revenue) as service_revenue,
    SUM(delivery_revenue) as delivery_revenue,
    SUM(insurance_revenue) as insurance_revenue,
    SUM(partner_commission) as partner_commission,
    SUM(net_revenue) as net_revenue,
    COUNT(DISTINCT order_id) as transactions
FROM Revenue_Records
GROUP BY DATE_FORMAT(transaction_date, '%Y-%m');


-- ============================================================================
-- SECTION 7: TRIGGERS FOR AUTOMATION
-- ============================================================================

DELIMITER //

-- Update customer total orders and lifetime value
CREATE TRIGGER update_customer_stats
AFTER INSERT ON Orders
FOR EACH ROW
BEGIN
    UPDATE Users
    SET total_bookings = (
        SELECT COUNT(*) 
        FROM Orders 
        WHERE user_id = NEW.user_id
    ),
    lifetime_value = (
        SELECT COALESCE(SUM(total_amount), 0)
        FROM Orders
        WHERE user_id = NEW.user_id 
        AND order_status = 'Completed'
    )
    WHERE user_id = NEW.user_id;
END//

-- Update promo code usage
CREATE TRIGGER update_promo_usage
AFTER INSERT ON Orders
FOR EACH ROW
BEGIN
    IF NEW.promo_code IS NOT NULL THEN
        UPDATE Promo
        SET times_used = times_used + 1
        WHERE promo_code = NEW.promo_code;
    END IF;
END//

-- Automatically create revenue record when payment is completed
CREATE TRIGGER create_revenue_record
AFTER UPDATE ON Payments
FOR EACH ROW
BEGIN
    IF NEW.status = 'Paid' AND (OLD.status IS NULL OR OLD.status != 'Paid') THEN
        INSERT INTO Revenue_Records (
            order_id,
            transaction_date,
            service_revenue,
            delivery_revenue,
            insurance_revenue,
            partner_commission,
            net_revenue,
            revenue_channel,
            service_type
        )
        SELECT 
            o.order_id,
            CURDATE(),
            o.base_price - o.delivery_fee - o.insurance_fee,
            o.delivery_fee,
            o.insurance_fee,
            CASE 
                WHEN o.partner_id IS NOT NULL THEN 
                    o.total_amount * (SELECT commission_rate FROM Partners WHERE partner_id = o.partner_id) / 100
                ELSE 0
            END,
            o.total_amount - o.discount_amount - CASE 
                WHEN o.partner_id IS NOT NULL THEN 
                    o.total_amount * (SELECT commission_rate FROM Partners WHERE partner_id = o.partner_id) / 100
                ELSE 0
            END,
            o.booking_channel,
            o.service_type
        FROM Orders o
        WHERE o.order_id = NEW.order_id;
    END IF;
END//

DELIMITER ;


-- ============================================================================
-- Migration Table
-- ============================================================================

CREATE TABLE migrations (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  version VARCHAR(255) NOT NULL,
  class VARCHAR(255) NOT NULL,
  `group` VARCHAR(255) NOT NULL,
  namespace VARCHAR(255) NOT NULL,
  time INT UNSIGNED NOT NULL,
  batch INT UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================================
-- SECTION 9: ENHANCED SEED DATA
-- ============================================================================

-- SEED: Insert sample users (your existing data + enhanced fields)
INSERT INTO Users (first_name, last_name, email, phone, social, social_num, nationality, customer_type, customer_segment, source_of_booking) VALUES
('John', 'Doe', 'john.doe@example.com', '+60168888888', 'MyKad', '123456789012', 'USA', 'tourist', 'short_stay', 'online'),
('Jane', 'Smith', 'jane.smith@example.com', '+60169999999', 'Passport', 'A12345678', 'UK', 'tourist', 'layover', 'partner'),
('Ahmad', 'Hassan', 'ahmad.hassan@example.com', '+60167777777', 'MyKad', '123456780123', 'Malaysia', 'local', NULL, 'walk-in'),
('Maria', 'Garcia', 'maria.garcia@example.com', '+60165555555', 'Passport', 'B98765432', 'Spain', 'business_traveller', 'short_stay', 'online');

-- SEED: Insert sample admin users (enhanced)
INSERT INTO Admins (staff_name, password, email, role, employment_type, hire_date) VALUES
('Admin User', '$2y$10$admin_password_hash_here', 'admin@easesarawak.com', 'Admin', 'full_time', '2024-01-15'),
('Super Admin', '$2y$10$superadmin_password_hash_here', 'superadmin@easesarawak.com', 'Superadmin', 'full_time', '2023-12-01'),
('Driver Ahmad', '$2y$10$driver_password_hash', 'driver1@easesarawak.com', 'Driver', 'full_time', '2024-02-01'),
('Sarah Handler', '$2y$10$handler_password_hash', 'handler1@easesarawak.com', 'Admin', 'part_time', '2024-03-15');

-- SEED: Insert sample locations (enhanced)
INSERT INTO Locations (name, category, address, total_capacity) VALUES
('Kuching International Airport', 'Airport', 'Kuching International Airport, Sarawak', 200),
('Hilton Kuching', 'Hotel', 'Jalan Tunku Abdul Rahman, Kuching', 100),
('Riverside Shopping Mall', 'Shopping Mall', 'Jalan Tunku Abdul Rahman, Kuching', 50),
('Sarawak Cultural Village', 'Other', 'Pantai Damai, Santubong', 30),
('EASE Main Hub', 'Hub', 'Kuching City Center, Sarawak', 500);

-- SEED: Insert sample promo codes (enhanced)
INSERT INTO Promo (promo_code, discount_type, discount_value, start_date, end_date, usage_limit, created_by) VALUES
('PROMO2025', 'Percent', 10.00, '2025-01-01 00:00:00', '2025-12-31 23:59:59', 100, 1),
('WELCOME50', 'Flat', 50.00, '2025-01-01 00:00:00', '2025-06-30 23:59:59', 50, 1),
('NEWUSER', 'Percent', 15.00, '2025-11-01 00:00:00', '2025-11-30 23:59:59', NULL, 2);

-- SEED: Insert sample partners (enhanced)
INSERT INTO Partners (name, commission_rate, type, contact_email, is_active) VALUES
('Sarawak Hotels Group', 5.50, 'Hotel', 'partners@sarawakhotels.com', TRUE),
('Local Tour Operators', 8.00, 'TourAgency', 'info@localtours.com', TRUE),
('Adventure Airbnb', 6.00, 'Airbnb', 'hosts@adventureairbnb.com', TRUE),
('Event Management Co', 10.00, 'Event', 'events@eventmgmt.com', TRUE),
('Express Delivery', 4.50, 'Other', 'contact@express.com', TRUE);


-- SEED: Insert sample tourist data
INSERT INTO Tourist_Arrivals_Data (period_start, period_end, location, total_arrivals, international_arrivals, domestic_arrivals, data_source) VALUES
('2024-10-01', '2024-10-31', 'Kuching', 45000, 15000, 30000, 'DOSM_API'),
('2024-11-01', '2024-11-30', 'Kuching', 52000, 18000, 34000, 'DOSM_API');

-- SEED: Insert sample local events
INSERT INTO Local_Events (event_name, event_type, event_start_date, event_end_date, expected_attendance, impact_level) VALUES
('Rainforest World Music Festival', 'festival', '2025-07-19', '2025-07-21', 25000, 'high'),
('Kuching Food Festival', 'festival', '2025-08-15', '2025-08-17', 15000, 'medium'),
('Sarawak Regatta', 'sports', '2025-09-20', '2025-09-22', 10000, 'medium');

-- Note: Continue with your existing seed data for orders, payments, luggage items, etc.


-- ============================================================================
-- Indexes
-- ============================================================================

CREATE INDEX idx_orders_pickup_date ON Orders(DATE(pickup_time));
CREATE INDEX idx_orders_created_month ON Orders((DATE_FORMAT(created_date, '%Y-%m')));
CREATE INDEX idx_revenue_month ON Revenue_Records((DATE_FORMAT(transaction_date, '%Y-%m')));
CREATE INDEX idx_tourist_period ON Tourist_Arrivals_Data(period_start, location);
CREATE INDEX idx_flights_date ON Flight_Schedules(DATE(scheduled_time));