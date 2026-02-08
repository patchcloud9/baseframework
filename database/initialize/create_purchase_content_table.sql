-- Purchase Content Table
-- Stores content for the Purchase page

CREATE TABLE IF NOT EXISTS purchase_content (
    id INT AUTO_INCREMENT PRIMARY KEY,

    -- Page title
    page_title VARCHAR(100) NOT NULL DEFAULT 'Purchase' COMMENT 'Main heading for purchase page',

    -- Main content
    content_text TEXT NULL COMMENT 'Main text content for purchase page',

    -- Contact email
    contact_email VARCHAR(255) NULL COMMENT 'Email address for purchase inquiries',

    -- Button details
    button_text VARCHAR(100) NULL COMMENT 'Text displayed on the button',
    button_url VARCHAR(255) NULL COMMENT 'URL the button links to',

    -- Timestamps
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Trigger to ensure only one row exists (singleton pattern)
DELIMITER $$
CREATE TRIGGER purchase_content_singleton_check
BEFORE INSERT ON purchase_content
FOR EACH ROW
BEGIN
    DECLARE row_count INT;
    SELECT COUNT(*) INTO row_count FROM purchase_content;
    IF row_count >= 1 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Only one purchase content record is allowed';
    END IF;
END$$
DELIMITER ;

-- Insert default content
INSERT INTO purchase_content (
    page_title,
    content_text,
    contact_email,
    button_text,
    button_url
) VALUES (
    'Purchase',
    'Thank you for your interest in purchasing artwork from Gail''s Original Fine Art. To proceed with a purchase of an origional artwork, please contact me directly at {email} with the details of the artwork you wish to acquire.\n\nFor prints and other merchandise featuring my artwork, please visit our Fine Art America store by clicking the button below.',
    NULL,
    'Fine Art America',
    'https://fineartamerica.com/profiles/gail-butler'
);
