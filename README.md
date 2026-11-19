# Madar Distribution Management System

An Arabic-first inventory and goods distribution web application built with PHP, MySQL/MariaDB, and responsive CSS. It supports branch-scoped operations, stock movement tracking, and role-based access.

## Features

- Role-based access for owners, company managers, branch managers, and employees.
- Company and branch data scoping enforced on the server.
- Product catalog with units, categories, costs, sale prices, and expiry dates.
- Configurable reorder levels, low-stock and expiry alerts, and inventory search and filters.
- Distribution transactions that update stock in a database transaction and retain branch-level history.
- Dashboard with stock summaries, monthly distribution totals, recent movements, and operational alerts.
- Arabic right-to-left interface with responsive layouts.
- Prepared SQL statements, password hashing, CSRF tokens, output escaping, and secure session settings.

## Technology

- PHP 8.0 or later with PDO MySQL
- MySQL or MariaDB
- Apache (XAMPP works for local development)
- HTML and CSS

## Local setup

1. Start Apache and MySQL/MariaDB.
2. Import `schema.sql` into the database server. It creates the `leader_app` database and tables.
3. Copy `config.example.php` to `config.local.php` and set the local database credentials. The local config is excluded from Git and blocked from direct web access.
4. Create the first owner account from a terminal in this folder:

   ```bash
   php create_admin.php "Madar Company" owner@example.com "A-strong-password-of-12-chars"
   ```

5. Open `http://localhost/Madar-Distribution/login.php` when using the folder name shown above.

For an existing installation, review `README-SECURITY.md` and run the relevant migration once after taking a database backup. Do not run migrations intended for older schemas on a new database.

## Scope

This project manages inventory and branch distribution movements. It does not currently issue sales invoices or integrate with ZATCA FATOORA.

## License

No license has been added yet.
