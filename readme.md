## Installation

Install PHP dependencies:

```sh
composer install
```

Install NPM dependencies:

```sh
npm ci
```

Build assets:

```sh
npm run dev
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

Create database.


Run database migrations:

```sh
php artisan migrate
```

Run database seeder:

```sh
php artisan db:seed
```

Run the dev server (the output will give the address):

```sh
php artisan serve
```

You're ready to go! Visit Ping CRM in your browser register or login with the admin credentials:

- **Username:** johndoe@example.com
- **Password:** secret

## Running The Scheduler Locally

A schedule command was created configured to run every 3 hours to import data from API, you must execute in your CLI the following command:
```sh
php artisan schedule:work
```
