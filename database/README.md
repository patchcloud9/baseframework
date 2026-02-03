# Database Setup

Simple SQL-based database setup using plain SQL files.

## Structure

```
database/
├── initialize/     # Table creation SQL files
│   ├── 01_create_users_table.sql
│   └── 02_create_logs_table.sql
└── seed/          # Data seeding SQL files
    ├── 01_seed_users.sql
    └── 02_seed_logs.sql
```

## Setup Instructions

### 1. Create Database

```sql
CREATE DATABASE myapp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Configure Connection

Update [config/config.php](../config/config.php) with your database credentials:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'myapp');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

### 3. Initialize Tables

Run each SQL file in the `initialize/` folder in order:

```bash
mysql -u your_username -p myapp < database/initialize/01_create_users_table.sql
mysql -u your_username -p myapp < database/initialize/02_create_logs_table.sql
```

Or run all at once:

```bash
cat database/initialize/*.sql | mysql -u your_username -p myapp
```

### 4. Seed Data (Optional)

Run each SQL file in the `seed/` folder:

```bash
mysql -u your_username -p myapp < database/seed/01_seed_users.sql
mysql -u your_username -p myapp < database/seed/02_seed_logs.sql
```

Or run all at once:

```bash
cat database/seed/*.sql | mysql -u your_username -p myapp
```

## Default Test Users

After seeding, these users will be available:

| Email | Password | Role |
|-------|----------|------|
| alice@example.com | password123 | admin |
| bob@example.com | password123 | user |
| carol@example.com | password123 | user |
| david@example.com | password123 | user |
| eve@example.com | password123 | admin |

## Adding New Tables

1. Create a new SQL file in `database/initialize/` with pattern: `##_create_tablename.sql`
2. Create corresponding model in `app/Models/`
3. Optionally create seed data in `database/seed/`

### Example: Create Posts Table

**File:** `database/initialize/03_create_posts_table.sql`

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

**File:** `database/seed/03_seed_posts.sql`

```sql
INSERT INTO posts (user_id, title, content) VALUES
(1, 'My First Post', 'This is the content of my first post.'),
(1, 'Another Post', 'More interesting content here.'),
(2, 'Bob\'s Thoughts', 'Sharing some thoughts with the world.');
```

## Using Models

After tables are created, use the Model classes to interact with the database:

```php
use App\Models\User;

// Find user
$user = User::find(1);

// Get all users
$users = User::all();

// Create user
$user = User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => password_hash('secret', PASSWORD_DEFAULT),
    'role' => 'user',
]);
```

See [app/Models/Model.php](../app/Models/Model.php) for full documentation.
