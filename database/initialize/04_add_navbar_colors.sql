-- Add navbar color customization columns to theme_settings table

ALTER TABLE theme_settings 
ADD COLUMN navbar_color VARCHAR(7) DEFAULT '#667eea' AFTER accent_color,
ADD COLUMN navbar_hover_color VARCHAR(7) DEFAULT '#ffffff' AFTER navbar_color;
