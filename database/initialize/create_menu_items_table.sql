-- Menu Items Table
-- Stores hierarchical navigation menu items with support for dropdowns

CREATE TABLE IF NOT EXISTS menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,

    -- Menu item details
    title VARCHAR(100) NOT NULL COMMENT 'Display text for the menu item',
    url VARCHAR(255) NOT NULL COMMENT 'Link destination (e.g., /, /about, /gallery)',
    icon VARCHAR(50) NULL COMMENT 'Font Awesome icon class (e.g., fa-home, fa-user)',

    -- Hierarchy support for dropdowns
    parent_id INT NULL COMMENT 'NULL for top-level items, ID for dropdown children',

    -- Ordering
    display_order INT NOT NULL DEFAULT 0 COMMENT 'Lower numbers appear first',

    -- Visibility control
    visibility ENUM('public', 'authenticated', 'admin') DEFAULT 'public' COMMENT 'Who can see this menu item',
    is_active TINYINT(1) DEFAULT 1 COMMENT '1 = visible, 0 = hidden',

    -- Special flags
    is_system TINYINT(1) DEFAULT 0 COMMENT '1 = system-managed (user menu), 0 = editable',
    open_new_tab TINYINT(1) DEFAULT 0 COMMENT '1 = target="_blank", 0 = normal link',

    -- Timestamps
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Indexes
    INDEX idx_parent_id (parent_id),
    INDEX idx_display_order (display_order),
    INDEX idx_visibility (visibility),
    INDEX idx_is_active (is_active),

    -- Foreign key constraint
    FOREIGN KEY (parent_id) REFERENCES menu_items(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default menu items (matching current nav.php)
INSERT INTO menu_items (title, url, icon, parent_id, display_order, visibility, is_active, is_system) VALUES
('Home', '/', 'fa-home', NULL, 1, 'public', 1, 0),
('About', '/about', NULL, NULL, 2, 'public', 1, 0),
('Gallery', '/gallery', 'fa-images', NULL, 3, 'public', 1, 0),
('Contact', '/contact', 'fa-envelope', NULL, 4, 'public', 1, 0);

-- Add Test Menu dropdown (matching current nav.php)
INSERT INTO menu_items (title, url, icon, parent_id, display_order, visibility, is_active, is_system) VALUES
('Test Menu', '#', NULL, NULL, 5, 'public', 1, 0);

SET @test_menu_id = LAST_INSERT_ID();

INSERT INTO menu_items (title, url, icon, parent_id, display_order, visibility, is_active, is_system) VALUES
('Test One', '/', NULL, @test_menu_id, 1, 'public', 1, 0),
('Test Two', '/', NULL, @test_menu_id, 2, 'public', 1, 0),
('Test Three', '/', NULL, @test_menu_id, 3, 'public', 1, 0);
