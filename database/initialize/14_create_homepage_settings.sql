-- Create homepage customization table

CREATE TABLE IF NOT EXISTS homepage_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    
    -- Hero Section
    hero_background_type VARCHAR(20) DEFAULT 'color', -- 'color' or 'image'
    hero_background_color VARCHAR(7) DEFAULT '#667eea',
    hero_background_image VARCHAR(255) NULL,
    
    -- Feature Cards (3 cards)
    card1_icon VARCHAR(50) DEFAULT 'fa-rocket',
    card1_title VARCHAR(100) DEFAULT 'Fast & Lightweight',
    card1_text TEXT,
    
    card2_icon VARCHAR(50) DEFAULT 'fa-code',
    card2_title VARCHAR(100) DEFAULT 'Easy to Understand',
    card2_text TEXT,
    
    card3_icon VARCHAR(50) DEFAULT 'fa-heart',
    card3_title VARCHAR(100) DEFAULT 'Built with Love',
    card3_text TEXT,
    
    -- Call to Action Button
    cta_button_text VARCHAR(100) DEFAULT 'Learn More',
    cta_button_link VARCHAR(255) DEFAULT '/about',
    
    -- Bottom Section (2 columns)
    bottom_section_layout VARCHAR(20) DEFAULT 'text-image', -- 'text-image' or 'image-text'
    bottom_section_title VARCHAR(255) DEFAULT 'How This Framework Works',
    bottom_section_text TEXT,
    bottom_section_image VARCHAR(255) NULL,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default values
INSERT INTO homepage_settings (
    card1_text,
    card2_text,
    card3_text,
    bottom_section_text
) VALUES (
    'No bloat, no dependencies. Just clean, efficient PHP code that gets the job done.',
    'Clear MVC structure with straightforward routing. Perfect for learning or building your own framework.',
    'Created as a teaching tool to demonstrate core PHP concepts without the complexity of large frameworks.',
    'This is a minimal MVC framework built from scratch to demonstrate routing, controllers, models, and views. Every component is designed to be easy to understand and modify.'
);
