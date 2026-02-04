-- Add hero text color fields to homepage_settings table

ALTER TABLE homepage_settings
ADD COLUMN hero_title_color VARCHAR(7) DEFAULT '#ffffff' AFTER hero_subtitle,
ADD COLUMN hero_subtitle_color VARCHAR(7) DEFAULT '#f5f5f5' AFTER hero_title_color;

-- Update existing row if it exists
UPDATE homepage_settings 
SET hero_title_color = '#ffffff',
    hero_subtitle_color = '#f5f5f5'
WHERE id = 1;
