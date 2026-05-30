# Halal Delights - Food Ordering System

A web-based food ordering platform developed using PHP, MySQL, HTML, CSS, JavaScript, and Bootstrap. The system allows customers to browse menu items, place orders, manage accounts, and communicate with administrators, while providing an admin panel for managing products, orders, and customer inquiries.

---

## Demo

### Screenshots & Walkthrough

A complete visual walkthrough of the project, including customer and admin interfaces, is available in the PDF below:

📄 [View Project Screenshots](Halal-Food-Website.pdf)

## Features

### Customer Features
- User Registration & Login
- Browse Food Menu
- Add Items to Cart
- Place Orders Online
- Order Tracking
- Contact & Support System
- Profile Management

### Admin Features
- Dashboard Overview
- Manage Food Items
- Manage Customer Orders
- Reply to Customer Queries via Email
- User Management
- Order Status Updates

### Technical Features
- Responsive Design
- PHP & MySQL Backend
- Session-Based Authentication
- Secure Password Hashing
- PHPMailer Email Integration
- Modular Code Structure

---

## Requirements

To run this project locally, install:

- XAMPP
- PHP 7.4 or higher
- MySQL
- Chrome, Firefox, or Edge

---

## Installation

### Step 1: Install XAMPP

1. Download XAMPP from:
   https://www.apachefriends.org/index.html

2. Install XAMPP.

3. Open the XAMPP Control Panel.

4. Start:
   - Apache
   - MySQL

---

### Step 2: Setup Project Files

Copy the project folder:

```text
halal-food-website
```

Paste it into:

```text
C:\xampp\htdocs\
```

---

## Database Setup

### Step 1: Open phpMyAdmin

Open:

```text
http://localhost/phpmyadmin
```

### Step 2: Create Database

Create a database named:

```sql
halal_food_db
```

### Step 3: Import Database

1. Select `halal_food_db`
2. Open the **Import** tab
3. Choose:

```text
halal_food_db.sql
```

4. Click **Import**

---

## Running the Project

After importing the database and placing the files in `htdocs`, open:

```text
http://localhost/halal-food-website/frontend/index.php
```

> If you renamed the project folder, replace `halal-food-website` in the URL with your folder name.

---

## Default Credentials

### Admin Account

```text
Username: admin
Password: 123
```

### Customer Account

Register a new account from the customer registration page.

---

## Reset Admin Credentials

To create new admin credentials:

1. Open:

```text
backend/reset-admin.php
```

2. Update the username and password.

3. Run:

```text
http://localhost/halal-food-website/backend/reset-admin.php
```

---

## Email Configuration (PHPMailer)

The admin can reply to customer inquiries directly through email.

### Step 1: Enable Two-Factor Authentication

1. Open your Google Account.
2. Go to:

```text
Security → 2-Step Verification
```

3. Enable Two-Step Verification.

---

### Step 2: Generate App Password

1. Search for:

```text
App Passwords
```

2. Create a new app password.

3. Copy the generated 16-character password.

Example:

```text
abcd efgh ijkl mnop
```

---

### Step 3: Configure PHPMailer

Open:

```text
reply-message.php
```

Replace:

```php
$mail->Username = 'username@gmail.com';
$mail->Password = '0000000000000000';
```

With:

```php
$mail->Username = 'your-email@gmail.com';
$mail->Password = 'your-app-password';
```

Also update:

```php
$mail->setFrom(
    'your-email@gmail.com',
    'Halal Delights Admin'
);
```

---

## Project Structure

```text
halal-food-website/
│
├── frontend/
│   ├── index.php
│   ├── menu.php
│   ├── cart.php
│   ├── checkout.php
│   └── profile.php
│
├── backend/
│   ├── admin-panel/
│   ├── reset-admin.php
│   ├── reply-message.php
│   └── database/
│
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
│
├── halal_food_db.sql
└── README.md
```

---

## Technologies Used

- PHP
- MySQL
- HTML5
- CSS3
- JavaScript
- Bootstrap
- PHPMailer
- XAMPP

---

## Future Enhancements

- Online Payment Gateway Integration
- SMS Notifications
- Food Delivery Tracking
- Discount & Coupon System
- Mobile Application Support
- Multi-Language Support

---

**Developers:**
- Kanwal Fatima
- Team Members

---
