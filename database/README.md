# Database Initialization & Seeding

This document explains how to initialize the MySQL database for this project and run the seed files. Recently the SQL files were consolidated and standardized for clarity.

## File layout

- `database/initialize/` — SQL files that create tables. Files follow the naming convention: `create_<table_name>.sql` (e.g., `create_users_table.sql`).
- `database/seed/` — SQL files that insert seed/test data. Files follow the naming convention: `seed_<something>.sql` (e.g., `seed_users.sql`).

> NOTE: Some older fragmented migration files were consolidated into the `create_*.sql` files. Use the `create_*.sql` files in `database/initialize/` to create your schema.

## Recommended workflow

1. Ensure your `config/config.php` database settings are correct (DB_HOST, DB_NAME, DB_USER, DB_PASS).

2. Create the target database (if necessary):

```sql
CREATE DATABASE myapp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

3. Apply create scripts (order matters if you rely on FK constraints). The simplest method is to run them in filename order:

```bash
# POSIX shells (Linux/macOS) - run all create scripts
cat database/initialize/create_*.sql | mysql -u your_username -p myapp
```

On Windows (PowerShell):

```powershell
Get-ChildItem -Path database\initialize\create_*.sql | Sort-Object Name | Get-Content | mysql -u your_username -p myapp
```

4. (Optional) Apply seed data:

```bash
cat database/seed/seed_*.sql | mysql -u your_username -p myapp
```

Windows (PowerShell):

```powershell
Get-ChildItem -Path database\seed\seed_*.sql | Sort-Object Name | Get-Content | mysql -u your_username -p myapp
```

5. Verification:
- Connect with `mysql` and run `SHOW TABLES;` and inspect sample records with `SELECT * FROM users LIMIT 5;`.

## Notes
- The SQL files are plain SQL and should work with MySQL/MariaDB.
- If your environment uses multiple migration scripts or a migration tool, import the SQL into your chosen migration system.
- The project does not enforce a specific migration tool; check in `database/initialize` for the canonical SQL files.

If you'd like, I can add an explicit list of the current `create_*.sql` and `seed_*.sql` files to this document or add a simple script to run them in the correct order. Let me know which you prefer.