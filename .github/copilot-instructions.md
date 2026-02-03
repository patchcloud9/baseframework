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

Routes are defined in [config/routes.php](../config/routes.php) using regex patterns:

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
- Layout wraps view content in `$content` variable (see [app/Views/layouts/main.php](../app/Views/layouts/main.php))
- Always escape output: `<?= htmlspecialchars($title) ?>`

### 3. Autoloading

PSR-4 style autoloader in [core/Autoloader.php](../core/Autoloader.php) maps:
- `Core\` → `/core/`
- `App\` → `/app/`

When adding new classes, follow namespace structure exactly. File `app/Services/LogService.php` must use `namespace App\Services;`

### 4. Database & Models

**Database Layer:**
- PDO wrapper at [core/Database.php](../core/Database.php) - singleton pattern with prepared statements
- Model base class at [app/Models/Model.php](../app/Models/Model.php) with CRUD: `find()`, `all()`, `create()`, `update()`, `delete()`
- Models use `$table`, `$fillable`, `$timestamps` properties
- Example models: [User.php](../app/Models/User.php), [Log.php](../app/Models/Log.php)

**Database Setup:**
- SQL files in `database/initialize/` create tables (numbered: `01_create_users_table.sql`)
- SQL files in `database/seed/` populate test data (numbered: `01_seed_users.sql`)
- Run initialization: `cat database/initialize/*.sql | mysql -u user -p dbname`
- Run seeds: `cat database/seed/*.sql | mysql -u user -p dbname`

**Adding New Tables:**
1. Create `database/initialize/##_create_tablename.sql`:
   ```sql
   CREATE TABLE IF NOT EXISTS posts (
       id INT AUTO_INCREMENT PRIMARY KEY,
       user_id INT NOT NULL,
       title VARCHAR(255) NOT NULL,
       content TEXT,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
       FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
       INDEX idx_user_id (user_id)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
   ```

2. Create model `app/Models/Post.php`:
   ```php
   <?php
   namespace App\Models;
   
   class Post extends Model
   {
       protected string $table = 'posts';
       protected array $fillable = ['user_id', 'title', 'content'];
       protected bool $timestamps = true;
   }
   ```

3. Optionally create `database/seed/##_seed_posts.sql`:
   ```sql
   INSERT INTO posts (user_id, title, content) VALUES
   (1, 'First Post', 'Content here'),
   (2, 'Another Post', 'More content');
   ```

### 5. Service Layer Pattern

See [app/Services/LogService.php](../app/Services/LogService.php) for the project's service pattern:
- Services handle business logic and data operations
- Controllers instantiate services and coordinate between them
- Services should use Models for database access
- Legacy: Some services use file-based JSON storage in `storage/`

## Development Workflow

### Running the Application

**Primary method:** Push to GitHub, pull from GitHub to a virtual server. (framework.hexgrid.org)
Application cannot be run directly; must use a web server.

**Production Infrastructure:**
- HTTPS handled by nginx reverse proxy manager
- SSL/TLS certificates managed at proxy level
- All HTTP traffic automatically redirected to HTTPS

### Debugging

- `APP_DEBUG` constant (in [config/config.php](../config/config.php)) controls error logging
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

1. **Add route** to [config/routes.php](../config/routes.php):
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

### New Model & Database Table

1. **Create SQL initialization file** `database/initialize/##_create_tablename.sql`
2. **Create model** at `app/Models/TableName.php` extending `Model`
3. **Run SQL**: `mysql -u user -p dbname < database/initialize/##_create_tablename.sql`
4. **Use in code**: `TableName::find($id)`, `TableName::create($data)`

### New Service

Follow `LogService.php` pattern:
- Store in `app/Services/`
- Use `namespace App\Services;`
- Constructor injects or instantiates dependencies
- Public methods for business logic
- Use Models for database operations

## Important Constraints

- **Database:** Uses MySQL via PDO with prepared statements
- **Models:** Extend `App\Models\Model` base class for CRUD operations
- **No middleware:** Authentication/CSRF not implemented; add at router level if needed
- **Sessions started globally:** `session_start()` called in [public/index.php](../public/index.php)
- **No dependency injection:** Controllers manually instantiate services

## Common Pitfalls

1. **URL parameters are strings:** Always cast before arithmetic: `(int) $id`
2. **Views need data extraction:** Use `$this->view()`, not direct `require`
3. **Flash messages are single-use:** Retrieved via `getFlash()` which unsets them
4. **Layouts wrap content:** The view goes into `$content`, not rendered directly
5. **Namespaces must match paths:** `App\Services\FooService` → `app/Services/FooService.php`

## Configuration

All config in [config/config.php](../config/config.php) using constants:
- `APP_NAME`, `APP_DEBUG`, `APP_URL`
- `DB_*` constants configured and in use
- Timezone set to `America/Los_Angeles`

**Note:** No `.env` file support yet; hardcode values in config.php

## Roadmap to Production

### Completed Features

#### ✅ 1. Database Layer (COMPLETE)
- ✅ **PDO wrapper class** at [core/Database.php](../core/Database.php) with prepared statements, singleton pattern
- ✅ **Model base class** at [app/Models/Model.php](../app/Models/Model.php) with CRUD: `find()`, `all()`, `where()`, `create()`, `update()`, `delete()`, `count()`
- ✅ **SQL-based initialization** in `database/initialize/` for table creation (numbered SQL files)
- ✅ **Seeding system** in `database/seed/` for test/demo data population
- ✅ **Example models**: [User.php](../app/Models/User.php), [Log.php](../app/Models/Log.php) with custom methods
- ✅ **Dual logging system**: LogService writes to both database and file with automatic failover
- ✅ **Production deployed**: Running on framework.hexgrid.org with MySQL database
- Pattern implemented: Services use Models, Models use Database class

#### 2. Security Hardening (COMPLETE ✅)
- ✅ **CSRF protection** via token validation in forms
  - ✅ Added `csrf_token()`, `csrf_field()`, `csrf_verify()` helpers
  - ✅ Validation in Controller base class before POST/PUT/DELETE
  - ✅ All existing forms updated with CSRF tokens
- ✅ **XSS prevention** - created `e()` helper for `htmlspecialchars()` shorthand, replaced throughout views
- ✅ **SQL injection protection** - enforced prepared statements in Database class (PDO)
- ✅ **Password hashing** - using `password_hash()` / `password_verify()` in User model
- ✅ **Rate limiting** - implemented Core\RateLimiter with token bucket algorithm
  - ✅ Session-based storage with per-IP identification
  - ✅ Contact form: 5 attempts per 60 seconds
  - ✅ User creation: 3 attempts per 5 minutes
- ✅ **Input validation** - created Core\Validator class with 15+ validation rules
  - ✅ Rules: required, email, min, max, numeric, integer, url, alpha, alphanumeric, in, confirmed, same, different, unique (with DB check and update ignore)
  - ✅ Contact form: validates name, email, message
  - ✅ User creation: validates name, email (unique), password (min 8)
  - ✅ User update: dynamic validation of changed fields only

#### 3. Middleware System (COMPLETE ✅)
- ✅ **Middleware base class** at [core/Middleware.php](../core/Middleware.php) - abstract class with handle() method
- ✅ **Router integration** - updated [core/Router.php](../core/Router.php) to execute middleware pipeline before controllers
- ✅ **Middleware aliases** - clean route definitions using aliases (csrf, auth, guest, rate-limit, log-request)
- ✅ **Built-in middleware**:
  - ✅ **CsrfMiddleware** - automatic CSRF validation on POST/PUT/DELETE/PATCH requests
  - ✅ **AuthMiddleware** - require authentication, redirect to login if not authenticated
  - ✅ **GuestMiddleware** - require NOT authenticated, redirect away if logged in
  - ✅ **RateLimitMiddleware** - throttle requests with configurable limits (rate-limit:key,max,seconds)
  - ✅ **LogRequestMiddleware** - automatic request logging with IP, user agent, referer
- ✅ **Clean controllers** - removed manual verifyCsrf() calls from all controllers (6 methods)
- ✅ **Routes updated** - all state-changing routes now use middleware in [config/routes.php](../config/routes.php)
- Pattern implemented: Router → Middleware Pipeline → Controller → Response

### Planned Features (Priority Order)

#### 4. Environment Configuration
- **`.env` file support** using `vlucas/phpdotenv` or custom parser
- **Environment-specific configs** - separate dev/staging/production settings
- **Secrets management** - never commit `.env`, use `.env.example` template
- Move all [config/config.php](../config/config.php) constants to `.env`

#### 5. Error Handling (Logging Complete ✅)
- **Exception handler** - catch all errors, log them, show user-friendly pages
- ✅ **Logging service** - dual persistence (database + file), auto-sync, graceful degradation
- **Error views** - styled 404/500 pages, different content for debug on/off
- **HTTP exception classes** - NotFoundHttpException, UnauthorizedHttpException, etc.

#### 6. Form Validation & Sanitization
Create `core/Validator.php`:
```php
$validator = new Validator($data, [
    'email' => 'required|email|max:255',
    'password' => 'required|min:8',
]);
```
- **Validation rules**: required, email, min, max, numeric, unique (DB check)
- **Error messages** stored in session, displayed in views
- **Old input** - repopulate form fields after validation failure

#### 7. Authentication & Authorization
- **User model** with authentication methods
- **Auth service** for login/logout/register
- **Session management** - secure session configuration
- **Remember me** functionality with tokens
- **Role-based permissions** - admin, user, guest roles

#### 8. Testing Infrastructure
- **PHPUnit** setup in `tests/` directory
- **Feature tests** - test routes/controllers with HTTP simulation
- **Unit tests** - test services/models in isolation
- **Test database** - separate SQLite/MySQL database for tests
- **CI/CD** - GitHub Actions to run tests on push

#### 9. API Support
- **RESTful controllers** - standardized JSON responses
- **API authentication** - token-based (Bearer tokens) or OAuth2
- **API versioning** - `/api/v1/` route prefix
- **Rate limiting** - throttle API requests per user/IP
- **CORS handling** - configure allowed origins

#### 10. Performance Optimization
- **Caching layer** - file/Redis cache for expensive queries
- **Query optimization** - eager loading, indexing strategies
- **Asset pipeline** - minify CSS/JS, combine files
- **OPcache** configuration for production PHP
- **CDN integration** - serve static assets from CDN

#### 11. Developer Experience
- **Debug toolbar** - show queries, timing, memory usage in dev mode
- **Artisan-style CLI** - commands for generating controllers/models/migrations
- **Code generation** - `php cli make:controller ProductController`
- **Database console** - interactive query runner
- **Hot reload** - auto-refresh browser on file changes (development)

#### 12. Production Deployment
- **Environment detection** - automatically detect and configure for production
- **Asset versioning** - cache busting with file hashes
- **HTTPS** - ✅ Already implemented via nginx reverse proxy manager
- **Security headers** - X-Frame-Options, CSP, HSTS (configure at nginx level)
- **Backup strategy** - automated database/file backups
- **Monitoring** - uptime checks, error tracking (Sentry integration)
- **Graceful degradation** - maintenance mode page

### Critical Security Checklist Before Production

- [x] Enable `display_errors = 0` in production PHP config
- [x] Use HTTPS only (✅ nginx reverse proxy manager)
- [x] Implement CSRF protection on all state-changing routes (✅ tokens + validation)
- [x] Validate and sanitize ALL user input (✅ e() helper, prepared statements, Validator class)
- [x] Use prepared statements for ALL database queries (✅ PDO with prepared statements)
- [x] Set secure session cookie flags: `httponly`, `secure`, `samesite` (✅ configured in index.php)
- [x] Implement rate limiting on authentication endpoints (✅ RateLimiter class, applied to contact and user creation)
- [ ] Add Content Security Policy headers
- [ ] Configure proper file upload restrictions (type, size, location)
- [ ] Remove or protect debug/test routes in production
- [ ] Set restrictive file permissions (755 for directories, 644 for files)
- [ ] Disable directory listing in web server config
- [ ] Keep framework and dependencies updated
- [x] Implement proper error logging (✅ dual database + file logging with graceful degradation)
- [ ] Use environment variables for sensitive configuration

### Implementation Priority

**Phase 1 - Core Stability (Weeks 1-2)** ✅ COMPLETE
- ✅ Database layer + Models
- Environment configuration (.env) - DEFERRED
- ✅ Error handling & logging

**Phase 2 - Security (Weeks 3-4)** ✅ COMPLETE
- ✅ CSRF protection
- ✅ Input validation
- ✅ Rate limiting
- ✅ Middleware pipeline

**Phase 3 - Developer Tools (Weeks 5-6)**
- Testing infrastructure
- CLI commands
- Debug toolbar

**Phase 4 - Production Ready (Weeks 7-8)**
- Performance optimization
- Security hardening
- Deployment configuration
- Monitoring setup

### When Adding Each Feature

**Database class example:**
```php
// core/Database.php
namespace Core;

class Database
{
    private \PDO $pdo;
    
    public function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
```

**Model base class example:**
```php
// app/Models/Model.php
namespace App\Models;

abstract class Model
{
    protected string $table;
    protected string $primaryKey = 'id';
    
    public function find(int $id): ?array
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?",
            [$id]
        )->fetch();
    }
}
```

**Middleware example:**
```php
// app/Middleware/AuthMiddleware.php
namespace App\Middleware;

class AuthMiddleware
{
    public function handle(): bool
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        return true;
    }
}
```
