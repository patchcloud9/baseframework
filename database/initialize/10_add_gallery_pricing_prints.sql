-- Add pricing and print purchase fields to gallery_images table

ALTER TABLE gallery_images 
ADD COLUMN price_type VARCHAR(50) DEFAULT 'hide' AFTER description;
-- Options: 'hide', 'amount', 'sold_prints', 'not_for_sale'

ALTER TABLE gallery_images 
ADD COLUMN price_amount DECIMAL(10, 2) NULL AFTER price_type;
-- Price in dollars if price_type is 'amount'

ALTER TABLE gallery_images 
ADD COLUMN prints_available TINYINT(1) DEFAULT 0 AFTER price_amount;
-- 0 = prints not available, 1 = prints available

ALTER TABLE gallery_images 
ADD COLUMN prints_url VARCHAR(512) NULL AFTER prints_available;
-- URL to print purchase page (e.g., Etsy, Fine Art America, etc.)

-- Add indexes
ALTER TABLE gallery_images 
ADD INDEX idx_price_type (price_type);
