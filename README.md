# PHP MVC Framework Skeleton

A minimal, educational PHP MVC framework demonstrating the front controller and routing pattern.

## Folder Structure

```
php-framework/
├── public/                 # Web root (point Apache/Nginx here)
│   ├── index.php           # Front controller - ALL requests go here
│   ├── .htaccess           # Apache URL rewriting rules
│   └── assets/             # CSS, JS, images (publicly accessible)
│
├── app/                    # Your application code
│   ├── Controllers/        # Handle requests, return responses
│   ├── Models/             # Data and business logic (for later)
│   └── Views/              # HTML templates
│       ├── layouts/        # Master templates (header, footer, nav)
│       ├── partials/       # Reusable snippets
│       └── errors/         # Error pages (404, 500)
│
├── core/                   # Framework engine (reusable across projects)
│   ├── Autoloader.php      # PSR-4 style class autoloading
│   └── Router.php          # URL matching and dispatching
│
├── config/
│   ├── config.php          # App settings (DB, timezone, etc.)
│   └── routes.php          # Route definitions
│
├── storage/                # Writable directory
│   ├── logs/
│   └── cache/
│
└── database/               # SQL files (for later)
    ├── migrations/
    └── seeds/
```

## How to Run

### Option 1: Docker (Recommended)

Create a `docker-compose.yml`:

```yaml
version: '3.8'
services:
  web:
    image: php:8.2-apache
    ports:
      - "8080:80"
    volumes:
      - ./:/var/www/html
    working_dir: /var/www/html/public
    command: >
      bash -c "a2enmod rewrite && 
               sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf &&
               apache2-foreground"
```

Then run:
```bash
docker-compose up
```

Visit: http://localhost:8080

### Option 2: PHP Built-in Server

```bash
cd public
php -S localhost:8080
```

Note: URL rewriting won't work perfectly with the built-in server.

### Option 3: Apache/XAMPP/MAMP

Point your document root to the `public/` folder.

## How Routing Works

1. **All requests hit `public/index.php`** (via `.htaccess` rewrite)
2. **Router loads routes from `config/routes.php`**
3. **Router matches URL patterns to controller methods**
4. **Controller handles request and returns response**

### Example Route

```php
// config/routes.php
'GET' => [
    '/users/(\d+)' => ['UserController', 'show'],
]
```

When you visit `/users/42`:
- Pattern `/users/(\d+)` matches
- `(\d+)` captures `42`
- Router calls `UserController::show('42')`

### Route Patterns

| Pattern | Matches | Example |
|---------|---------|---------|
| `/` | Exact root | `/` |
| `/about` | Exact path | `/about` |
| `/users/(\d+)` | Digits | `/users/123` |
| `/posts/([a-z-]+)` | Lowercase + hyphens | `/posts/my-first-post` |
| `/api/v(\d+)/users` | Version number | `/api/v2/users` |

## Key Files to Study

1. **`public/index.php`** - The single entry point
2. **`core/Router.php`** - How URL matching works
3. **`config/routes.php`** - Route definitions
4. **`app/Controllers/Controller.php`** - Base controller with helpers
5. **`app/Controllers/UserController.php`** - Example with URL parameters

## Next Steps

After understanding routing, you might add:

- [ ] Database class (PDO wrapper)
- [ ] Model base class
- [ ] Middleware (authentication, CSRF)
- [ ] Form validation
- [ ] Environment variables (.env file)
