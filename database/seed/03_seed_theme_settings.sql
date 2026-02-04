-- Seed Theme Settings
-- Initializes theme configuration with current Bulma-based color palette

INSERT INTO theme_settings (
    primary_color,
    secondary_color,
    accent_color,
    navbar_color,
    navbar_hover_color,
    logo_path,
    favicon_path,
    header_style,
    card_style
) VALUES (
    '#667eea',  -- Primary: Bulma purple/blue (used in nav gradient start)
    '#764ba2',  -- Secondary: Bulma purple (used in nav gradient end)
    '#48c78e',  -- Accent: Bulma success green (used for success messages/buttons)
    '#667eea',  -- Navbar: Background color for navigation bar
    '#ffffff',  -- Navbar Hover: Text color when hovering over nav items
    NULL,       -- Logo: No custom logo yet (uses APP_NAME text)
    NULL,       -- Favicon: No custom favicon yet (uses browser default)
    'static',   -- Header: Static positioning (default)
    'default'   -- Cards: Default Bulma card style
);
