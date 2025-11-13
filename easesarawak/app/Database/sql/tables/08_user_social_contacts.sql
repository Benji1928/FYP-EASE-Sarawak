-- User Social Contacts Table
CREATE TABLE User_Social_Contacts (
  social_contact_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  platform VARCHAR(50) NOT NULL COMMENT 'whatsapp, wechat, line, telegram',
  contact_handle VARCHAR(255) NOT NULL,
  is_primary BOOLEAN DEFAULT FALSE,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
