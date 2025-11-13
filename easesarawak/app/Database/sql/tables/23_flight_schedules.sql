-- Flight Schedules Table
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
