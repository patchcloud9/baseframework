-- Add text alignment fields to about_content table
-- Allows admins to control horizontal and vertical alignment of text sections

ALTER TABLE about_content
    ADD COLUMN section1_text_align_h ENUM('left', 'center', 'right') DEFAULT 'left'
        COMMENT 'Horizontal text alignment for section 1' AFTER section1_image_position,
    ADD COLUMN section1_text_align_v ENUM('top', 'middle', 'bottom') DEFAULT 'top'
        COMMENT 'Vertical text alignment for section 1' AFTER section1_text_align_h,
    ADD COLUMN section2_text_align_h ENUM('left', 'center', 'right') DEFAULT 'left'
        COMMENT 'Horizontal text alignment for section 2' AFTER section2_image_position,
    ADD COLUMN section2_text_align_v ENUM('top', 'middle', 'bottom') DEFAULT 'top'
        COMMENT 'Vertical text alignment for section 2' AFTER section2_text_align_h;
