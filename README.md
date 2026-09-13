# Company Management Portal

## Project Overview

A Laravel Breeze application for authenticated users to manage company records. Each user can create, update, and delete only their own companies, including logo uploads, services, branches, and country/state/city locations.

## Requirements

- PHP 8.3 or later
- Composer 2
- Node.js 20 or later with npm
- SQLite, MySQL, or another Laravel-supported database

## Installation

```bash
git clone https://github.com/mitalthanki/BSP-TASK.git
cd bsp-task
composer install
npm install
```

## Setup Instructions

1. Create the environment file and application key:

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

2. Configure the database connection in `.env`.

   For SQLite, create the database file if it does not exist:

    ```bash
    touch database/database.sqlite
    ```

   Then set:

    ```env
    DB_CONNECTION=sqlite
    DB_DATABASE=/absolute/path/to/bsp-task/database/database.sqlite
    ```

3. Run migrations and seed the location, service, and branch data:

    ```bash
    php artisan migrate --seed
    ```

4. Create the public storage link for company logos:

    ```bash
    php artisan storage:link
    ```

5. Start the application:

    ```bash
    composer run dev
    ```

   Open the address shown in the terminal, normally `http://localhost:8000`.

## Migration Commands

Run pending migrations:

```bash
php artisan migrate
```

Run migrations with seed data:

```bash
php artisan migrate --seed
```

Rebuild the database and seed it again. This deletes all existing database data:

```bash
php artisan migrate:fresh --seed
```

## Seeder Commands

Run all registered seeders:

```bash
php artisan db:seed
```

Run a specific seeder:

```bash
php artisan db:seed --class=CountrySeeder
php artisan db:seed --class=StateSeeder
php artisan db:seed --class=CitySeeder
php artisan db:seed --class=ServiceSeeder
php artisan db:seed --class=BranchSeeder
```

## Storage Link Command

Company logos are stored on Laravel's `public` disk at:

```text
storage/app/public/company-logos
```

Expose these files to the browser with:

```bash
php artisan storage:link
```

## Features

- Laravel Breeze registration, login, logout, password reset, and profile management
- Authenticated company CRUD with user ownership protection
- Company logo upload with image validation, unique filenames, replacement cleanup, and previews
- Multiple services and branches per company through many-to-many relationships
- Responsive company create, edit, and listing pages
- Country, state, and city dependent dropdowns using AJAX
- Protected JSON endpoints:
  - `GET /states/{country}`
  - `GET /cities/{state}`
- Request validation for company data, locations, logo uploads, services, and branches
- Eager loading and database indexes for efficient company listing queries

## Architecture Overview

The application follows Laravel's MVC architecture.

- **Models**: `Company`, `Country`, `State`, `City`, `Service`, and `Branch` define the database relationships.
- **Migrations**: define normalized tables, foreign keys, pivot tables, unique constraints, and performance indexes.
- **Seeders**: provide countries, states, cities, services, and branches required by the forms.
- **Form Requests**: `StoreCompanyRequest` and `UpdateCompanyRequest` centralize validation rules.
- **Controllers**: `CompanyController` handles authenticated company CRUD; `LocationController` returns dependent location JSON data.
- **Views**: Blade templates use Laravel Breeze components and Tailwind CSS for responsive UI.
- **Security**: routes are protected by authentication middleware; company queries are scoped to the current user; Blade escapes dynamic output by default.

## Technologies Used

- Laravel 13
- PHP 8.3+
- Laravel Breeze
- Blade templates
- Tailwind CSS
- Alpine.js
- Vite
- SQLite by default (configurable for other Laravel-supported databases)
- PHPUnit and Laravel Pint
