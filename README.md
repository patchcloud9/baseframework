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
│   ├── Models/             # Database models (User, Log, etc.)
│   └── Views/              # HTML templates
│       ├── layouts/        # Master templates (header, footer, nav)
│       ├── partials/       # Reusable snippets
│       └── errors/         # Error pages (404, 500)
│
├── core/                   # Framework engine (reusable across projects)
│   ├── Autoloader.php      # PSR-4 style class autoloading
│   ├── Router.php          # URL matching and dispatching
│   └── Database.php        # PDO wrapper for database access
│
├── config/
│   ├── config.php          # App settings (DB, timezone, etc.)
│   └── routes.php          # Route definitions
│
├── storage/                # Writable directory
│   ├── logs/
│   └── cache/
│
└── database/               # Database setup
    ├── initialize/         # Table creation SQL files
    └── seed/              # Data seeding SQL files
```

## Database Setup

This framework uses MySQL with PDO for database access.

### 1. Create Database

```sql
CREATE DATABASE myapp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Configure Connection

Edit `config/config.php` with your database credentials:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'myapp');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

### 3. Initialize Tables

Run the SQL files in `database/initialize/`:

```bash
cat database/initialize/*.sql | mysql -u your_username -p myapp
```

### 4. Seed Test Data (Optional)

```bash
cat database/seed/*.sql | mysql -u your_username -p myapp
```

See [database/README.md](database/README.md) for detailed instructions.

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
3. **`core/Database.php`** - PDO wrapper for database operations
4. **`config/routes.php`** - Route definitions
5. **`app/Controllers/Controller.php`** - Base controller with helpers
6. **`app/Controllers/UserController.php`** - Example with database CRUD operations
7. **`app/Models/Model.php`** - Base model with CRUD methods
8. **`app/Models/User.php`** - Example model implementation

## Using Models

The framework includes a Model base class for database operations:

```php
use App\Models\User;

// Find by ID
$user = User::find(1);

// Get all records
$users = User::all();

// Find by conditions
$admins = User::where(['role' => 'admin']);

// Create
$user = User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => password_hash('secret', PASSWORD_DEFAULT),
    'role' => 'user',
]);

// Update
User::update(1, ['name' => 'Jane Doe']);

// Delete
User::delete(1);
```

## Next Steps

The framework is ready for development. Consider adding:

- [ ] Middleware (authentication, CSRF)
- [ ] Form validation
- [ ] Environment variables (.env file)
- [ ] API authentication
- [ ] Email functionality
