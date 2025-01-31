# Wymianka

This web application simplify the process of exchanging items through barter.

## Features

-   Items CRUD
-   Filtering items using their
    -   name
    -   location
    -   category
-   Trade offers CRUD
-   Messages
-   Notifications
-   User profiles
-   User rating
-   Email verification

## Build with

-   Vue.js
-   Laravel
-   Inertia.js
-   Tailwind CSS
-   MariaDB
-   Pusher
-   MailHog
-   [Geoapify](https://www.geoapify.com/download-all-the-cities-towns-villages/)

## Run Locally

1. Clone the project

```bash
  git clone https://github.com/KozaPawel/wymianka
```

2. Go to the project directory

```bash
  cd wymianka
```

3. Install dependencies

```bash
  cp .env.example .env
```

4. Run docker commands

```bash
  docker compose build
  docker compose up
```

5. Install dependencies

```bash
  npm install
  composer install
```

6. Generate application key

```bash
  php artisan key:generate
```

7. Generate storage link

```bash
  php artisan storage:link
```

8. In .env file fill

```bash
  DB_PASSWORD=root
```

9. Run migrations

```bash
  php artisan migrate
```

10. Seed database (seeding towns takes some time you can trim them in /database/data/towns.csv)

```bash
  php artisan db:seed
```

11. Fill .env file with your Pusher data

```bash
  PUSHER_APP_ID=
  PUSHER_APP_KEY=
  PUSHER_APP_SECRET=
  PUSHER_APP_CLUSTER=
```

12. Run application

```bash
  npm run dev
  php artisan serve
```

### Runs at http://127.0.0.1:8000/

### Test user credentials

```
test@example.com
password
```
