-- Add gallery contact email to theme_settings table

ALTER TABLE theme_settings 
ADD COLUMN gallery_contact_email VARCHAR(255) NULL AFTER site_name;
