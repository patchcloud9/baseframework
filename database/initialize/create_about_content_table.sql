-- About Content Table
-- Stores content for the About page with two sections (image + text pairs)

CREATE TABLE IF NOT EXISTS about_content (
    id INT AUTO_INCREMENT PRIMARY KEY,

    -- Page title
    page_title VARCHAR(100) NOT NULL DEFAULT 'About the Artist' COMMENT 'Main heading for about page',
    page_subtitle VARCHAR(255) NULL COMMENT 'Optional subtitle displayed under the page title',

    -- Section 1 (top)
    section1_image VARCHAR(255) NULL COMMENT 'Path to first section image',
    section1_text TEXT NULL COMMENT 'Text content for first section',
    section1_image_position ENUM('left', 'right') DEFAULT 'left' COMMENT 'Image position for section 1',

    -- Section 2 (bottom)
    section2_image VARCHAR(255) NULL COMMENT 'Path to second section image',
    section2_text TEXT NULL COMMENT 'Text content for second section',
    section2_image_position ENUM('left', 'right') DEFAULT 'left' COMMENT 'Image position for section 2',

    -- Artist signature/name
    artist_signature VARCHAR(100) NULL COMMENT 'Artist name displayed at bottom',

    -- Timestamps
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Trigger to ensure only one row exists (singleton pattern)
DELIMITER $$
CREATE TRIGGER about_content_singleton_check
BEFORE INSERT ON about_content
FOR EACH ROW
BEGIN
    DECLARE row_count INT;
    SELECT COUNT(*) INTO row_count FROM about_content;
    IF row_count >= 1 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Only one about content record is allowed';
    END IF;
END$$
DELIMITER ;

-- Insert default content
INSERT INTO about_content (
    page_title,
    page_subtitle,
    section1_text,
    section1_image_position,
    section2_text,
    section2_image_position,
    artist_signature
) VALUES (
    'About the Artist',
    '',
    'As I sit here in my quiet place, some call a studio.\nI''m recalling my early days of art.\nI was obsessed with drawing. Mostly pencil sketches of cabins in the woods.\nI was always dreaming.\n\nNow, I''m putting those early days to passionate work.\nMostly acrylic on canvas, things that catch my eye.',
    'left',
    'Dan, reminds me that I see things as "paint worthy".\nSome of my inspirations come from the two place we live in.\nThe Methow Valley (Twisp) and the Okanogan.\n\nWhat catches your eye?',
    'left',
    'Gail'
);
