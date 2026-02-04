-- Add navbar text color column to theme_settings table

ALTER TABLE theme_settings 
ADD COLUMN navbar_text_color VARCHAR(7) DEFAULT '#ffffff' AFTER navbar_hover_color;
