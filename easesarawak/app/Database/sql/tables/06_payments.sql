-- Payments Table
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
