-- Luggage Items Table
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
