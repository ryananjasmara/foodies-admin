# Foodies - Admin
This is a simple yet functional project built with Laravel.

## Features
- Login
- Manage Users, Products, Admins and Orders
- Export Order
- Manage Access Control List

## Tech Stack
- `Laravel`
- `Bootstrap`
- `Postgresql`

## How to Install

Follow these steps to set up the project locally:

1. **Clone the repository:**
```sh
git clone git@github.com:ryananjasmara/foodies-admin.git
cd foodies-admin
```

2. **Install Dependencies**
```sh
compose install
```

3. **Setup Database**

I am using Docker for the pgsql database for this project.

```sh
docker-compose up
```

4. **Generate Application Key**
```sh
php artisan key:generate
```

5. **Run Migration Script & Seed The DB**
```sh
php artisan migrate
php artisan db:seed
```

6. **Run The Application**
```sh
php artisan serve
```


