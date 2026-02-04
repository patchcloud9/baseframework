-- Add site name column to theme_settings table
-- The site name appears in the navigation after the logo

ALTER TABLE theme_settings
ADD COLUMN site_name VARCHAR(100) DEFAULT NULL COMMENT 'Site name displayed in navigation' AFTER logo_path;
