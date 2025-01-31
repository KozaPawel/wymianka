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

## Screenshots
![screenshot1](https://github.com/user-attachments/assets/db4fc62e-e183-4283-b595-a0ebd3928718)

![screenshot2](https://github.com/user-attachments/assets/ec3c616d-8a63-4e80-bf9b-38537e7e9342)

![screenshot3](https://github.com/user-attachments/assets/bd5f1561-5588-4373-a0f4-eba28b3aa3e2)

![screenshot4](https://github.com/user-attachments/assets/75b0307b-cc8d-4bfb-bcc3-bb84ffbca530)

![screenshot5](https://github.com/user-attachments/assets/2d932420-5de8-4fb8-b5a5-d81fd15efc8b)

![screenshot6](https://github.com/user-attachments/assets/0fd6c7d0-04ea-4c41-a4c1-d9ab445787fe)

![screenshot7](https://github.com/user-attachments/assets/1f4147d6-4a73-4f41-bd63-aca5594d711c)

![screenshot8](https://github.com/user-attachments/assets/0c6c62fd-e5e4-46d8-8dba-87b147a3fa45)

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
