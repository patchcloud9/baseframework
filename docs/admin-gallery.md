# Gallery Admin

The Gallery section lets you publish artwork to the public-facing gallery on the OVGC website. You can upload images, add titles and descriptions, set pricing information, control print availability, and arrange the order in which pieces appear.

---

## Table of Contents

1. [How the Gallery Works](#how-the-gallery-works)
2. [Getting to the Gallery Admin](#getting-to-the-gallery-admin)
3. [Uploading a New Image](#uploading-a-new-image)
4. [Setting Pricing and Print Options](#setting-pricing-and-print-options)
5. [Editing an Existing Image](#editing-an-existing-image)
6. [Changing Display Order](#changing-display-order)
7. [Deleting an Image](#deleting-an-image)
8. [Field Reference](#field-reference)
9. [Tips and Gotchas](#tips-and-gotchas)

---

## How the Gallery Works

When you upload an image in the admin, it immediately appears on the public gallery page at `/gallery`. The gallery shows **12 images per page**, ordered by the display order you set — images you move to the top appear first. Within the same position, newer uploads appear before older ones.

Each image has:
- A **title** and optional **description** that visitors see
- **Pricing information** — you choose what (if anything) to show: a price, a "Not for Sale" label, an "Original Sold" notice, or nothing at all
- An optional **link to purchase prints** if you sell prints through an outside service like Etsy or Fine Art America

> [!info]
> The gallery is public — anyone visiting the website can see it. No login is required to view gallery images.

---

## Getting to the Gallery Admin

1. Log in to the admin panel.
2. Navigate to:
   ```
   /admin/gallery
   ```
3. You will see a stats bar at the top showing the total number of images and how many have been uploaded in the last 7 days, followed by the upload form, and then a grid of all existing images.

<!-- SCREENSHOT: The full /admin/gallery page showing the stats bar at the top ("Total Images" and "Recent (7 days)"), the "Upload New Image" card below it, and the image grid at the bottom. Capture enough of the page to show all three sections. -->

---

## Uploading a New Image

<!-- SCREENSHOT: The "Upload New Image" form card, fully visible, with no file selected yet. Show all fields including the file picker, Title, Description, Pricing Display dropdown, and the Prints Available checkbox. -->

1. On the **Manage Gallery** page (`/admin/gallery`), find the **Upload New Image** card.
2. Click **Choose a file…** and select an image from your computer.
   - Accepted formats: JPG, PNG, GIF, WebP
   - Maximum file size: **5 MB**
   - After selecting, the filename will appear next to the button so you can confirm you picked the right file.
3. Enter a **Title** for the image. This is required and will appear as the image's label on the public gallery.
4. Optionally enter a **Description** (up to 1,000 characters). A short caption or artwork notes work well here.
5. Choose a **Pricing Display** option (see [Setting Pricing and Print Options](#setting-pricing-and-print-options) below).
6. Check **Prints are available for purchase** if you offer prints, and paste in the purchase link if so.
7. Click **Upload Image**.

If the upload succeeds, the page will reload and you will see a green confirmation message. The new image will appear at the bottom of the grid (lowest display order priority by default) and at the end of the public gallery.

> [!note]
> If you see a red error message after clicking Upload, read it carefully — common causes are:
> - File type not supported (e.g., HEIC or TIFF files won't work — convert to JPG first)
> - File is larger than 5 MB
> - Title is missing or too short (minimum 3 characters)

<!-- SCREENSHOT: The upload form after a file has been selected, showing the filename displayed next to the "Choose a file..." button. The Title field should have example text filled in. -->

---

## Setting Pricing and Print Options

The **Pricing Display** dropdown controls what pricing label (if any) visitors see on each image in the public gallery. There are four options:

| Option | What visitors see |
|---|---|
| Hide — Don't show pricing | No price label at all |
| Show Price — Display dollar amount | A dollar amount you enter (e.g., $400.00) |
| Original Sold (Prints Available) | "Original Sold" notice |
| Not for Sale | "Not for Sale" label |

> [!tip]
> The **Price Amount** field only appears on screen after you select "Show Price." If you switch away from "Show Price," the amount field hides itself — you don't need to clear it manually.

**To set a specific price:**
1. Select **Show Price — Display dollar amount** from the dropdown.
2. The **Price Amount** field will appear. Enter the price as a number (e.g., `400.00`).

**To offer prints:**
1. Check the **Prints are available for purchase** checkbox.
2. The **Prints Purchase URL** field will appear. Paste the full web address (URL) of the page where visitors can buy prints — for example, your Etsy listing or Fine Art America page.

> [!warning]
> If you check "Prints are available for purchase" but leave the URL blank, the public gallery will show that prints are available but visitors will have no link to click. Always paste a URL when enabling prints.

<!-- SCREENSHOT: The pricing section of the upload form with "Show Price" selected in the dropdown, the "Price Amount" field visible and filled with "400.00", and the "Prints are available for purchase" checkbox checked with the URL field visible and filled in. -->

---

## Editing an Existing Image

You can update an image's title, description, and pricing at any time. The image file itself cannot be swapped out — to replace the photo, you must delete the entry and upload the new file as a fresh image.

1. On the **Manage Gallery** page, find the image card you want to change.
2. Click **Edit** in the card's footer.
3. On the Edit page, update the **Title**, **Description**, and/or pricing fields as needed.
4. Click **Save Changes**. You will be returned to the gallery management page with a confirmation message.
5. To leave without saving, click **Cancel**.

<!-- SCREENSHOT: The Edit Gallery Image page, showing the image preview on the left and the edit form on the right. The form should have all fields visible with example data filled in. -->

> [!info]
> The Edit page shows the original filename, upload date, and who uploaded the image — handy for keeping track of your content.

---

## Changing Display Order

Images are displayed on the public gallery in the order you set here. Lower position = appears earlier (further left / higher up on the page).

Each image card has **Up** and **Down** buttons:

- **Up** — moves the image one position earlier in the gallery
- **Down** — moves the image one position later

After clicking Up or Down, the page reloads and automatically scrolls back to the image you just moved, briefly highlighting it in green so you can find it easily.

> [!tip]
> Reordering moves images one step at a time. If you need to move an image from the bottom to the top of a large gallery, you will need to click **Up** multiple times.

<!-- SCREENSHOT: Two or three image cards in the admin grid, showing the card footer clearly with the Up, Down, Edit, View, and Delete buttons/links labeled. -->

---

## Deleting an Image

> [!warning]
> Deleting an image is **permanent**. The image file is removed from the server and cannot be recovered. There is no trash or undo.

1. On the **Manage Gallery** page, find the image card you want to remove.
2. Click **Delete** in the card's footer (shown in red).
3. A pop-up will ask you to confirm: *"Are you sure you want to delete [title]? This action cannot be undone."*
4. Click **OK** to confirm, or **Cancel** to go back.

If confirmed, the image disappears from the admin grid and from the public gallery immediately.

<!-- SCREENSHOT: The browser's native confirmation dialog (pop-up) that appears when Delete is clicked, showing the image title in the message and the OK/Cancel buttons. -->

---

## Field Reference

### Upload / Edit Form Fields

| Field | Required? | Rules | Notes |
|---|---|---|---|
| Image File | Yes (upload only) | JPG, PNG, GIF, or WebP; max 5 MB | Cannot be changed after upload — delete and re-upload to replace |
| Title | Yes | 3–255 characters | Shown on the public gallery card |
| Description | No | Max 1,000 characters | Only the first ~80 characters show on the admin grid card; full text shows on the public detail page |
| Pricing Display | Yes | One of four options (see table above) | Defaults to "Hide" |
| Price Amount | Conditional | Numbers only; max $999,999.99 | Only appears when "Show Price" is selected |
| Prints Available | No | Checkbox | When checked, reveals the Prints URL field |
| Prints Purchase URL | Conditional | Must be a valid web address (starts with https://) | Only appears when Prints Available is checked |

### Pricing Display Options

| Value | When to use |
|---|---|
| Hide | Artwork is not currently for sale and you don't want any label |
| Show Price | Original is available; you want to display the asking price |
| Original Sold (Prints Available) | Original has sold but prints are still available |
| Not for Sale | Artwork is displayed for viewing only, not available to buy |

---

## Tips and Gotchas

> [!tip]
> **Convert phone photos before uploading.** iPhones and Android phones often save photos as HEIC or HEIF format, which the gallery does not accept. Open the photo in a free converter (or use Windows Photos > Save a copy as JPEG) before uploading.

> [!warning]
> **You cannot replace an image file.** The Edit form only updates text and pricing. If you uploaded the wrong photo, use Delete on the old card and then upload the correct file fresh. The new upload will appear at the end of the grid — use the Up/Down buttons to reposition it.

> [!warning]
> **Deletes are immediate and permanent.** There is no confirmation email or recovery option. Double-check you are deleting the right image before clicking OK in the confirmation dialog.

> [!note]
> **Order resets on fresh installs.** If the site database is ever wiped and rebuilt, display order is recalculated from upload date (newest first). Any custom ordering you set would need to be re-done.

> [!tip]
> **Prints URL and pricing work independently.** You can mark an original as "Not for Sale" and still offer prints by checking the Prints Available checkbox. The pricing label and the prints link are separate controls.

> [!note]
> **The public gallery is paginated.** Visitors see 12 images per page. Images in display-order positions 1–12 appear on page 1, positions 13–24 on page 2, and so on. Put your most important or featured work at the top with the Up button.
