-- Add display_order column to gallery_images table
-- Allows manual ordering of images in the gallery

ALTER TABLE gallery_images 
ADD COLUMN display_order INT NOT NULL DEFAULT 0 AFTER uploaded_by;

-- Add index for faster sorting
ALTER TABLE gallery_images 
ADD INDEX idx_display_order (display_order);

-- Set initial display_order based on created_at (newest first gets lower order number)
SET @row_number = 0;
UPDATE gallery_images 
SET display_order = (@row_number:=@row_number + 1)
ORDER BY created_at DESC;
