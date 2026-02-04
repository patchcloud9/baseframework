-- Add footer tagline to theme_settings table

ALTER TABLE theme_settings 
ADD COLUMN footer_tagline VARCHAR(255) NULL AFTER gallery_contact_email;
