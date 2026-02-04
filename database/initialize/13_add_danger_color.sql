-- Add danger/destructive button color to theme_settings table

ALTER TABLE theme_settings 
ADD COLUMN danger_color VARCHAR(7) DEFAULT '#f14668' AFTER accent_color;
