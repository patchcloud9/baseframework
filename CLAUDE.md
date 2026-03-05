# CLAUDE.md — PHP MVC Framework

## Project Overview

Minimal educational PHP MVC framework with front controller and routing patterns.
Production deployment: **framework.hexgrid.org** (nginx reverse proxy, HTTPS).
Cannot run locally without a web server — deploy via GitHub push/pull to the virtual server.

## Architecture

```
Browser → public/index.php → Router::dispatch() → Controller → View → Response
```

- **Front controller**: `public/index.php` — all requests enter here
- **Router**: `core/Router.php` — regex URL matching
- **Controllers**: extend `App\Controllers\Controller` (view/redirect/json/flash helpers)
- **Models**: extend `App\Models\Model` (CRUD: find/all/create/update/delete)
- **Services**: business logic in `app/Services/` (see `LogService.php` for pattern)
- **Views**: PHP templates using layouts (`$content` var) and partials
- **Config**: constants in `config/config.php`; `.env` file for secrets (never commit)
- **Routes**: defined in `config/routes.php`

## Key Conventions

- **Namespaces must match paths**: `App\Services\FooService` → `app/Services/FooService.php`
- **URL params are strings**: always cast before arithmetic — `(int) $id`
- **Output escaping**: use `<?= e($var) ?>` or `htmlspecialchars()` — never raw echo
- **Database**: PDO via `core/Database.php` singleton; always use prepared statements
- **Sessions**: started globally in `public/index.php`
- **Flash messages**: single-use — retrieved via `getFlash()` which unsets them
- **Views**: pass data as array to `$this->view()`, extracted as variables inside template
- **Autoloader**: PSR-4 style — `Core\` → `/core/`, `App\` → `/app/`
- **Timezone**: `America/Los_Angeles`

## Database

- SQL init files: `database/initialize/create_<table>_table.sql`
- SQL seed files: `database/seed/seed_<name>.sql`
- No migrations workflow — use create + seed scripts for fresh installs
- Models define `$table`, `$fillable`, `$timestamps` properties

## Middleware Available

- `csrf` — CSRF token validation
- `auth` — require authenticated session
- `guest` — require NOT authenticated
- `role:admin` — require specific role
- `rate-limit:key,max,seconds` — rate limiting

## Security — Non-Negotiable

- Prepared statements for ALL queries
- `e()` / `htmlspecialchars()` on ALL output
- CSRF tokens on ALL state-changing requests
- Password hashing with bcrypt (`password_hash`)
- Secure session flags set in `public/index.php`
- File uploads: MIME validation, 2MB limit, random filenames, no SVG

## Adding Features

**New route + controller:**
1. Add to `config/routes.php`
2. Create `app/Controllers/FooController.php` extending `Controller`
3. Create view at `app/Views/foo/action.php`

**New model + table:**
1. Create `database/initialize/create_<name>_table.sql`
2. Create `app/Models/Foo.php` extending `Model`

**New service:**
1. Create `app/Services/FooService.php` with `namespace App\Services;`
2. Use Models for DB access; controllers instantiate services directly (no DI container)

## Debugging

- `APP_DEBUG` in `config/config.php` gates debug output
- `/debug` route shows request/server/routing diagnostics
- Logs: dual-persistence (`LogService`) — database + file fallback at `storage/logs/`

## What NOT to Do

- Do not use `display_errors` in production
- Do not commit `.env`
- Do not bypass CSRF validation
- Do not use raw SQL without prepared statements
- Do not echo user input without escaping
- Do not add unnecessary abstraction — this framework is intentionally lightweight
