# Homepage Customization

## Overview

The homepage customization system allows administrators to configure all aspects of the homepage through an admin interface at `/admin/homepage`.

## Features

### 1. Hero Section
- **Background Type**: Choose between solid color or image
- **Background Color**: Color picker for solid color background
- **Background Image**: Upload a custom hero background image (JPG, PNG, GIF, WebP, max 5MB)

### 2. Feature Cards (3 Cards)
Each card can be customized with:
- **Icon**: Font Awesome class (e.g., `fas fa-rocket`)
- **Title**: Card heading (max 100 characters)
- **Description**: Card text content

Browse Font Awesome icons at: https://fontawesome.com/icons

### 3. Call to Action Button
- **Button Text**: Text displayed on the button (max 100 characters)
- **Button Link**: URL the button links to (e.g., `/about`, `/contact`, `/gallery`)

### 4. Bottom Content Section
Two-column layout with:
- **Layout**: Choose "Text Left, Image Right" or "Image Left, Text Right"
- **Title**: Section heading (max 255 characters)
- **Text Content**: Main text content (supports line breaks)
- **Image**: Upload a section image (JPG, PNG, GIF, WebP, max 5MB)

## Database Schema

Table: `homepage_settings`

| Column | Type | Description |
|--------|------|-------------|
| id | INT | Primary key (always 1, singleton) |
| hero_background_type | ENUM('color', 'image') | Hero background type |
| hero_background_color | VARCHAR(7) | Hex color code |
| hero_background_image | VARCHAR(255) | Path to hero image |
| card1_icon | VARCHAR(50) | Font Awesome class for card 1 |
| card1_title | VARCHAR(100) | Title for card 1 |
| card1_text | TEXT | Description for card 1 |
| card2_icon | VARCHAR(50) | Font Awesome class for card 2 |
| card2_title | VARCHAR(100) | Title for card 2 |
| card2_text | TEXT | Description for card 2 |
| card3_icon | VARCHAR(50) | Font Awesome class for card 3 |
| card3_title | VARCHAR(100) | Title for card 3 |
| card3_text | TEXT | Description for card 3 |
| cta_button_text | VARCHAR(100) | Call-to-action button text |
| cta_button_link | VARCHAR(255) | Call-to-action button URL |
| bottom_section_layout | ENUM('text-image', 'image-text') | Two-column layout |
| bottom_section_title | VARCHAR(255) | Bottom section heading |
| bottom_section_text | TEXT | Bottom section content |
| bottom_section_image | VARCHAR(255) | Path to bottom section image |
| created_at | TIMESTAMP | Record creation timestamp |
| updated_at | TIMESTAMP | Last update timestamp |

## File Structure

```
app/
  Controllers/
    HomepageController.php      # Admin customization controller
    HomeController.php           # Public homepage controller
  Models/
    HomepageSetting.php          # Singleton model
  Views/
    admin/
      homepage.php               # Admin customization form
    home/
      index.php                  # Public homepage view
      
database/
  initialize/
    14_create_homepage_settings.sql  # Database table + defaults
    
public/
  uploads/
    homepage/                    # Uploaded images stored here
```

## Routes

| Method | Path | Handler | Middleware |
|--------|------|---------|------------|
| GET | /admin/homepage | HomepageController@index | auth, role:admin |
| POST | /admin/homepage | HomepageController@update | auth, role:admin, csrf |

## Usage

### For Administrators

1. Navigate to Admin Panel (`/admin`)
2. Click "Homepage Settings" button
3. Customize any section:
   - Hero: Choose color or upload image
   - Cards: Change icons, titles, descriptions
   - CTA Button: Update text and link
   - Bottom Section: Choose layout, upload image, write content
4. Click "Save Settings"
5. View changes on homepage (`/`)

### For Developers

**Get homepage settings in controller:**
```php
use App\Models\HomepageSetting;

$settings = HomepageSetting::getSettings();
```

**Update homepage settings:**
```php
HomepageSetting::updateSettings([
    'hero_background_color' => '#667eea',
    'card1_title' => 'New Title',
    // ... other fields
]);
```

**In views:**
```php
<?= e($settings['card1_title']) ?>
<i class="<?= e($settings['card1_icon']) ?>"></i>
```

## Default Values

On initial setup, default values are provided:

- **Hero**: Solid color (#667eea)
- **Card 1**: "Fast Performance" with rocket icon
- **Card 2**: "Secure" with shield icon
- **Card 3**: "Responsive" with mobile icon
- **CTA Button**: "Get Started" → `/about`
- **Bottom Section**: "About This Framework" with description

## Validation Rules

| Field | Rules |
|-------|-------|
| hero_background_type | required, must be 'color' or 'image' |
| card1_title | required, max 100 characters |
| card2_title | required, max 100 characters |
| card3_title | required, max 100 characters |
| cta_button_text | required, max 100 characters |
| cta_button_link | required, max 255 characters |
| bottom_section_layout | required, must be 'text-image' or 'image-text' |
| bottom_section_title | required, max 255 characters |
| hero_background_image | optional, image type, max 5MB |
| bottom_section_image | optional, image type, max 5MB |

## Image Upload

**Allowed types:** JPG, JPEG, PNG, GIF, WebP  
**Max size:** 5MB  
**Storage location:** `public/uploads/homepage/`  
**Naming:** `prefix_uniqueid.extension` (e.g., `hero_abc123.jpg`)

### File Upload Security

- MIME type validation using `finfo_file()`
- File size validation (5MB limit)
- Unique filenames prevent overwrites
- Files stored outside document root (served through public/)

## Mobile Responsiveness

The homepage is fully mobile-responsive:

- **Hero**: Full-width on all devices
- **Feature Cards**: Stack vertically on mobile, 3-column on desktop
- **CTA Button**: Full-width on mobile
- **Bottom Section**: Stacks vertically on mobile, side-by-side on desktop
  - Uses `.is-reverse-mobile` class for proper mobile ordering

## Notes

- Homepage settings use a **singleton pattern** (single row, ID always 1)
- Hero background from theme settings (`.hero.is-primary`) does NOT affect homepage (uses inline styles)
- Icon preview updates in real-time as you type Font Awesome classes
- File input names update when files are selected
- All text output is escaped with `e()` helper to prevent XSS

## Future Enhancements

Potential additions:
- Multiple homepage layouts (templates)
- Drag-and-drop card reordering
- Rich text editor for content sections
- Image cropping/resizing on upload
- Preview mode before saving
- Page-specific SEO meta tags
