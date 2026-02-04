-- Add hero text fields to homepage_settings table

ALTER TABLE homepage_settings
ADD COLUMN hero_title VARCHAR(100) DEFAULT 'Welcome Home' AFTER id,
ADD COLUMN hero_subtitle VARCHAR(255) DEFAULT 'Your PHP MVC Framework' AFTER hero_title;

-- Update existing row if it exists
UPDATE homepage_settings 
SET hero_title = 'Welcome Home',
    hero_subtitle = 'Your PHP MVC Framework'
WHERE id = 1;
