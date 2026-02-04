-- Add hero customization columns to theme_settings table

ALTER TABLE theme_settings 
ADD COLUMN hero_background_color VARCHAR(7) DEFAULT NULL AFTER navbar_text_color,
ADD COLUMN hero_background_image VARCHAR(255) DEFAULT NULL AFTER hero_background_color;
