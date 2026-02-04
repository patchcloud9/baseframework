-- Seed Homepage Settings
-- Inserts default homepage content into homepage_settings table

INSERT INTO homepage_settings (
    hero_title,
    hero_subtitle,
    hero_title_color,
    hero_subtitle_color,
    card1_text,
    card2_text,
    card3_text,
    bottom_section_text
) VALUES (
    'Welcome Home',
    'Your PHP MVC Framework',
    '#ffffff',
    '#f5f5f5',
    'No bloat, no dependencies. Just clean, efficient PHP code that gets the job done.',
    'Clear MVC structure with straightforward routing. Perfect for learning or building your own framework.',
    'Created as a teaching tool to demonstrate core PHP concepts without the complexity of large frameworks.',
    'This is a minimal MVC framework built from scratch to demonstrate routing, controllers, models, and views. Every component is designed to be easy to understand and modify.'
);