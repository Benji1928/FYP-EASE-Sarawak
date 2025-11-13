-- Admins Table
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
