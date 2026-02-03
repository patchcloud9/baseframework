# PHP MVC Framework - AI Coding Instructions

## Architecture Overview

This is a **minimal, educational PHP MVC framework** demonstrating front controller and routing patterns. The framework is intentionally lightweight - not a production framework (yet, but hope to be someday) but a teaching tool for understanding MVC fundamentals.

### Core Components

- **Front Controller**: ALL requests hit `public/index.php`, which dispatches to the router
- **Router**: `core/Router.php` uses regex patterns to match URLs to controller methods
- **Controllers**: Extend `App\Controllers\Controller` base class with view/redirect/JSON helpers
- **Views**: PHP templates using layouts (wrapper templates) and partials (reusable snippets)
- **Services**: Business logic layer (see `LogService.php` for file-based data storage pattern)

### Request Flow

```
Browser → public/index.php → Router::dispatch() → Controller → View → Response
```

## Critical Patterns

### 1. Routing System

Routes are defined in [config/routes.php](config/routes.php) using regex patterns:

```php
'GET' => [
    '/users/(\d+)' => ['UserController', 'show'],  // Captures numeric ID
    '/posts/([a-z-]+)/comments/(\d+)' => ['PostController', 'showComment'],  // Multiple params
]
```

**Key behaviors:**
- URL parameters are captured via regex groups and passed as string arguments to controller methods
- The router automatically converts `UserController` → `App\Controllers\UserController`
- Always cast URL params: `$userId = (int) $id;` before using as array keys
- Trailing slashes are normalized (both `/about` and `/about/` work)

### 2. Controller Conventions

Controllers extend `Controller` base class which provides:

- `view($path, $data, $layout)` - Render views with optional layout wrapper
- `partial($path, $data)` - Render without layout
- `json($data, $code)` - Return JSON responses
- `redirect($url)` - HTTP redirects
- `input($key)` / `query($key)` - Access POST/GET data
- `flash($type, $message)` - Session-based flash messages

**View rendering:** 
- Views use `extract()` to convert data array to variables: `['user' => $user]` becomes `$user`
- Layout wraps view content in `$content` variable (see [app/Views/layouts/main.php](app/Views/layouts/main.php))
- Always escape output: `<?= htmlspecialchars($title) ?>`

### 3. Autoloading

PSR-4 style autoloader in [core/Autoloader.php](core/Autoloader.php) maps:
- `Core\` → `/core/`
- `App\` → `/app/`

When adding new classes, follow namespace structure exactly. File `app/Services/LogService.php` must use `namespace App\Services;`

### 4. Service Layer Pattern

See [app/Services/LogService.php](app/Services/LogService.php) for the project's service pattern:
- Services handle business logic and data operations
- Controllers instantiate services and coordinate between them
- This codebase uses **file-based JSON storage** (not a database) for simplicity
- Files stored in `storage/logs/app.json` with simple incrementing IDs

## Development Workflow

### Running the Application

**Primary method:** Push to GitHub, pull from GitHub to a virtual server. (framework.hexgrid.org)
Application cannot be run directly; must use a web server.

### Debugging

- `APP_DEBUG` constant (in [config/config.php](config/config.php)) controls error logging
- Router logs matched routes to `error_log` when debug is enabled
- Flash messages use session storage - check `$_SESSION['flash']` structure
- The `/debug` route shows request/server info

### Testing Routes

Visit [/debug](https://framework.hexgrid.org/debug) to see:
- Current HTTP method and URI
- Server variables
- Route matching diagnostics

## Adding New Features

### New Route + Controller

1. **Add route** to [config/routes.php](config/routes.php):
   ```php
   'GET' => [
       '/products/(\d+)' => ['ProductController', 'show'],
   ]
   ```

2. **Create controller** at `app/Controllers/ProductController.php`:
   ```php
   <?php
   namespace App\Controllers;
   
   class ProductController extends Controller
   {
       public function show(string $id): void
       {
           $this->view('products/show', ['productId' => $id]);
       }
   }
   ```

3. **Create view** at `app/Views/products/show.php`:
   - Access layout variables like `$content`, `$title`
   - Use `<?= $productId ?>` for safe output

### New Service

Follow `LogService.php` pattern:
- Store in `app/Services/`
- Use `namespace App\Services;`
- Constructor sets up file paths or dependencies
- Public methods for CRUD operations
- Use JSON files in `storage/` for persistence

## Important Constraints

- **No database:** This framework uses file-based storage only (see `LogService`)
- **No models yet:** Business logic lives in Services, not separate Model classes
- **No middleware:** Authentication/CSRF not implemented; add at router level if needed
- **Sessions started globally:** `session_start()` called in [public/index.php](public/index.php)
- **No dependency injection:** Controllers manually instantiate services

## Common Pitfalls

1. **URL parameters are strings:** Always cast before arithmetic: `(int) $id`
2. **Views need data extraction:** Use `$this->view()`, not direct `require`
3. **Flash messages are single-use:** Retrieved via `getFlash()` which unsets them
4. **Layouts wrap content:** The view goes into `$content`, not rendered directly
5. **Namespaces must match paths:** `App\Services\FooService` → `app/Services/FooService.php`

## Configuration

All config in [config/config.php](config/config.php) using constants:
- `APP_NAME`, `APP_DEBUG`, `APP_URL`
- `DB_*` constants present but unused (future feature)
- Timezone set to `America/Los_Angeles`

**Note:** No `.env` file support yet; hardcode values in config.php
