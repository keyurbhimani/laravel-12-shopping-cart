# 🛒 Laravel E-commerce Shopping Cart

A simple, clean e-commerce shopping cart built with **Laravel 12**, **Livewire**, and **Tailwind CSS**.  
The cart is **database-driven and user-based**, not session-based.

---

## Tech Stack

- Laravel 12
- Livewire (v3)
- Tailwind CSS
- Laravel Breeze (Authentication)
- MySQL
- Database Queue

---

## Features

- User authentication (Laravel Breeze)
- Product listing with search & pagination
- Add, update, and remove cart items
- Cart linked to authenticated user
- Stock validation
- Low stock email notification (Queue Job)
- Checkout & order creation
- Daily sales report (Scheduled Job)
- Order Listing

---

## Installation

### 1. Clone Project
```
git clone <repository-url>
cd ecommerce-cart
```

### 2. Install Dependencies
```
composer install
npm install
npm run dev
```

### 3. Environment Setup
```
cp .env.example .env
php artisan key:generate
```

Update .env

```
DB_DATABASE=ecommerce
DB_USERNAME=root
DB_PASSWORD=

MAIL_USERNAME=your_username_here
MAIL_PASSWORD=your_password_here
```

Database
```
php artisan migrate
```

If jobs table are not created in the database then run the below command
```
php artisan queue:table
php artisan migrate
```

Seeder
```
php artisan db:seed
```

Running the Application
```
php artisan serve
php artisan queue:listen
npm run dev
php artisan daily:sales
```