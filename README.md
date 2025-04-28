# Finanz API

A financial management API built with Laravel and PostgreSQL.

## Technologies

- Laravel 11
- PostgreSQL
- PHP 8.2+
- Composer
- DBeaver (optional, for DB management)

## Project Setup

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/finanz-api.git
cd finanz-api
```

2. Install Dependencies
```bash
composer install
```
3. Configure Environment
.env.example and update your database settings:
```bash
cp .env.example .env
```
Edit your .env file:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```
Generate application key:
```bash
php artisan key:generate
```

4. Run Migrations and Seeders
Run the database migrations:
```bash
php artisan migrate
```
Run the necessary seeders:
```bash
php artisan db:seed --class=IncomeTypesTableSeeder
php artisan db:seed --class=UsersTableSeeder
```
You should now have the default Income Types and Users seeded into the database.
