# Gallery Commerce Features - Deployment Instructions

## Overview
This update adds pricing, contact email, and print purchase functionality to the gallery system.

## Database Migrations Required

Run these SQL files on the production database in order:

### 1. Add Pricing and Prints Fields to Gallery Images
```bash
mysql -u root -p baseframework < database/initialize/10_add_gallery_pricing_prints.sql
```

This adds:
- `price_type` - VARCHAR(50) - Options: 'hide', 'amount', 'sold_prints', 'not_for_sale'
- `price_amount` - DECIMAL(10,2) - Dollar amount for original artwork
- `prints_available` - TINYINT(1) - 0 or 1 for print availability
- `prints_url` - VARCHAR(512) - URL to print purchase page

### 2. Add Gallery Contact Email to Theme Settings
```bash
mysql -u root -p baseframework < database/initialize/11_add_gallery_contact_email.sql
```

This adds:
- `gallery_contact_email` - VARCHAR(255) - Email displayed on gallery pages

## Testing After Deployment

1. **Test Admin Upload Form**
   - Navigate to `/admin/gallery`
   - Upload a new image with pricing and print options
   - Verify conditional fields show/hide correctly:
     - Price amount field shows only when "Show Price" is selected
     - Prints URL field shows only when "Prints available" is checked

2. **Test Public Gallery Display**
   - Navigate to `/gallery` and click an image
   - Verify pricing displays correctly based on type:
     - Dollar amount: "Original Artwork: $400.00"
     - Sold prints: "Original Sold (Prints Available)"
     - Not for sale: "Not for Sale"
     - Hide: No pricing box shown
   - Verify contact email displays if set in theme settings
   - Verify print purchase button:
     - Enabled with external link icon if prints_available = 1 and URL is set
     - Disabled "Prints Not Available" if prints_available = 0

3. **Test Theme Settings**
   - Navigate to `/admin/theme`
   - Set Gallery Contact Email
   - Verify it appears on gallery image detail pages

## Files Changed

### Database
- `database/initialize/10_add_gallery_pricing_prints.sql` - New pricing/prints columns
- `database/initialize/11_add_gallery_contact_email.sql` - Gallery email in theme_settings

### Models
- `app/Models/GalleryImage.php` - Added fillable fields: price_type, price_amount, prints_available, prints_url
- `app/Models/ThemeSetting.php` - Added fillable field: gallery_contact_email

### Controllers
- `app/Controllers/GalleryController.php` - Updated store() method with new field validation and database insert

### Views
- `app/Views/gallery/admin.php` - Added form fields for pricing/prints with conditional display via JavaScript
- `app/Views/gallery/show.php` - Display pricing box, contact email, and prints button
- `app/Views/admin/theme.php` - Added Gallery Contact Email field

### JavaScript
- Added `togglePriceAmount()` function to show/hide price amount field
- Added `togglePrintsUrl()` function to show/hide prints URL field
- DOMContentLoaded initializer for conditional fields

## Configuration

After deployment, set the gallery contact email:
1. Log in as admin
2. Navigate to `/admin/theme`
3. Scroll to "Gallery Contact Email" field
4. Enter email address (e.g., artist@example.com)
5. Click "Update Theme Settings"

This email will appear on all gallery image detail pages when pricing is displayed.

## Feature Details

### Pricing Options (per image)
- **Hide** - No pricing information displayed
- **Show Price** - Display dollar amount (e.g., "$400.00 for original artwork")
- **Original Sold (Prints Available)** - Message for sold originals
- **Not for Sale** - Display "Not for Sale" message

### Print Purchase Feature
- Checkbox to enable prints for each image
- URL field for external print shop (Etsy, Fine Art America, etc.)
- Button displays on public gallery with "Purchase Prints and Merchandise" text
- Opens in new tab with external link icon
- Disabled state shows "Prints Not Available" when unchecked

### Contact Email
- Set once in theme settings
- Displays on all gallery images (when pricing is shown)
- Format: "For inquiries: artist@example.com"
- Leave empty to hide email from gallery pages
