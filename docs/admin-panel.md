# Admin Panel

The Admin Panel is the control center for the OVGC website. From one page you can jump to every management section — pages, settings, users, and logs — and get a quick summary of recent site activity. Only accounts with the "admin" role can access it.

---

## Table of Contents

1. [How the Admin Panel Works](#how-the-admin-panel-works)
2. [Getting to the Admin Panel](#getting-to-the-admin-panel)
3. [Pages Section](#pages-section)
4. [Settings Section](#settings-section)
5. [Developer Tools Section](#developer-tools-section)
6. [Recent Activity Section](#recent-activity-section)
7. [Quick Reference: What Each Button Does](#quick-reference-what-each-button-does)
8. [Tips and Gotchas](#tips-and-gotchas)

---

## How the Admin Panel Works

The Admin Panel at `/admin` is a **dashboard** — it doesn't let you change anything directly. Instead, it gives you clearly labeled buttons that take you to each management area of the site.

When you open it, you'll see:
- A welcome message with your name
- **Pages** — manage the content on each public-facing page
- **Settings** — control site-wide appearance, navigation, and user accounts
- **Developer Tools** — diagnostic buttons for troubleshooting the site (advanced)
- **Recent Activity** — a short list of the five most recent events the site has logged

> [!info]
> The Admin Panel is only visible to admin accounts. If a visitor or a regular logged-in user tries to go to `/admin`, they will be redirected away automatically. You do not need to do anything to protect the page — it is locked down by the site itself.

<!-- SCREENSHOT: The full /admin page as an admin user sees it, showing the welcome message at the top ("Welcome, [Name]!"), the Pages box, the Settings box, the Developer Tools box, and at least the top of the Recent Activity table. Capture the whole page or scroll through to show all four boxes. -->

---

## Getting to the Admin Panel

**Option 1 — Navigation menu:**
1. Make sure you are logged in with an admin account.
2. Click your name in the top-right corner of any page.
3. In the dropdown that appears, click **Admin Panel**.

**Option 2 — Direct URL:**
1. In your browser's address bar, type:
   ```
   /admin
   ```
   (or the full address: `https://framework.hexgrid.org/admin`)
2. Press Enter.

> [!note]
> If you are not logged in, going to `/admin` will redirect you to the login page. After logging in, you may need to navigate back to `/admin` manually.

<!-- SCREENSHOT: The navigation bar in the top-right corner, showing the user name dropdown open with "Admin Panel" and "Logout" visible as options. -->

---

## Pages Section

The **Pages** box contains buttons for editing the content on the main public pages of the website.

<!-- SCREENSHOT: Just the "Pages" box with its four buttons — Homepage, About, Gallery, Purchase — clearly visible. -->

| Button | What it manages | URL |
|---|---|---|
| **Homepage** | The main landing page — headline, hero image, welcome text | `/admin/homepage` |
| **About** | The "About" page — bio text and photo | `/admin/about` |
| **Gallery** | Upload, edit, reorder, and delete artwork images | `/admin/gallery` |
| **Purchase** | The "Purchase" page — text and ordering information | `/admin/purchase` |

> [!tip]
> Changes made through any Pages button take effect immediately — there is no "publish" step. As soon as you save, the public page updates.

---

## Settings Section

The **Settings** box controls site-wide options that affect every page at once.

<!-- SCREENSHOT: Just the "Settings" box with its four buttons — Theme, Menu, Users, Logs — clearly visible. -->

| Button | What it manages | URL |
|---|---|---|
| **Theme** | Colors, fonts, logo, and visual style of the whole site | `/admin/theme` |
| **Menu** | The navigation links that appear in the top menu and footer | `/admin/menu` |
| **Users** | Admin accounts — create, edit, and delete user accounts | `/admin/users` |
| **Logs** | A searchable record of site activity and errors | `/logs` |

> [!warning]
> **Theme and Menu changes are site-wide and instant.** Changing the theme colors or removing a menu item affects every visitor immediately. If you're experimenting, make small changes one at a time so you can tell what caused any unintended result.

---

## Developer Tools Section

The **Developer Tools** box contains diagnostic buttons intended for troubleshooting. As a site admin you have access to them, but in normal day-to-day use you won't need them.

<!-- SCREENSHOT: Just the "Developer Tools" box with the three buttons — Debug Info, Test 404, Test 500 — clearly visible. Note that these buttons appear lighter/gray compared to the blue buttons in the other boxes. -->

| Button | What it does |
|---|---|
| **Debug Info** | Shows a technical summary of the server and current request — useful to share with a developer when reporting a bug |
| **Test 404** | Opens a sample "Page Not Found" error page in a new tab so you can see what visitors see when they hit a missing link |
| **Test 500** | Opens a sample "Server Error" page in a new tab — for checking that the error page looks correct |

> [!note]
> The Debug Info page contains technical details about the server (file paths, PHP settings, session data). It is safe to view yourself, but avoid sharing screenshots of it publicly — treat it like a password.

---

## Recent Activity Section

At the bottom of the Admin Panel, a **Recent Activity** table shows the last 5 events the site has recorded — things like logins, admin actions, or errors.

<!-- SCREENSHOT: The "Recent Activity" table showing a few rows of log entries. The table should show the Level column (with colored tags — blue for "Info", yellow for "Warning", red for "Error"), the Message column, and the Time column. The "View All Logs →" button should be visible below the table. -->

Each row in the table has three columns:

| Column | What it shows |
|---|---|
| **Level** | A colored label: **Info** (blue) for normal events, **Warning** (yellow) for things worth watching, **Error** (red) for problems |
| **Message** | A short description of what happened |
| **Time** | The date and time the event was recorded |

To see the full history, click **View All Logs →** at the bottom of the table. This opens the Logs page, which you can also reach from the Settings section above.

> [!info]
> If the Recent Activity section does not appear at all, it means the site has not recorded any log entries yet — this is normal on a freshly set up site.

---

## Quick Reference: What Each Button Does

| Section | Button | Where it takes you |
|---|---|---|
| Pages | Homepage | Edit the main landing page |
| Pages | About | Edit the About page |
| Pages | Gallery | Manage artwork images |
| Pages | Purchase | Edit the Purchase page |
| Settings | Theme | Change site colors and appearance |
| Settings | Menu | Edit navigation links |
| Settings | Users | Manage admin accounts |
| Settings | Logs | View site activity and error log |
| Developer Tools | Debug Info | View server diagnostics |
| Developer Tools | Test 404 | Preview the "Page Not Found" error page |
| Developer Tools | Test 500 | Preview the "Server Error" error page |

---

## Tips and Gotchas

> [!tip]
> **Bookmark `/admin`.** Once you're logged in, bookmarking the admin panel URL saves you from hunting through the menu every time. Most browsers let you press Ctrl+D (Windows) or Cmd+D (Mac) to bookmark the current page.

> [!warning]
> **There is no "undo" for most admin actions.** Saving changes to a page, deleting an image, or removing a user all take effect immediately and permanently. Read confirmation prompts carefully before clicking OK.

> [!note]
> **The admin panel only appears for admin accounts.** If you create a new user account and log in as that user, you will not see "Admin Panel" in the dropdown and `/admin` will redirect you away. Only accounts set to the "admin" role have access. The Users section (`/admin/users`) is where you can grant admin access.

> [!tip]
> **Recent Activity is a quick health check.** Glancing at the Recent Activity table each time you visit the admin panel is an easy habit — a sudden spike in red "Error" entries can signal a problem worth investigating before visitors notice it.

> [!warning]
> **Logging out is important on shared computers.** The site keeps you logged in across browser sessions. If you use a shared or public computer, always click your name in the top menu and choose **Logout** when you're done. Simply closing the browser tab does not log you out.
