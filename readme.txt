======================================================
         HALAL DELIGHTS - FOOD ORDERING SYSTEM
======================================================

Thank you for reviewing the Halal Delights project. 
Follow the steps below to set up and run the website on your local machine.

------------------------------------------------------
1. REQUIREMENTS
------------------------------------------------------
To run this project, you need a local server environment.
* Software: XAMPP
* PHP Version: 7.4 or higher.
* Browser: Chrome, Firefox, or Edge.

------------------------------------------------------
2. INSTALLATION STEPS
------------------------------------------------------
Step 1: Install XAMPP
   - Download XAMPP from https://www.apachefriends.org/index.html
   - Install it and open the "XAMPP Control Panel".
   - Click "Start" next to **Apache** and **MySQL**.

Step 2: Setup Project Files
   - Copy the project folder (e.g., "halal-food-website") 
   - Paste it inside the XAMPP "htdocs" directory.
     (Default location: C:\xampp\htdocs\)

------------------------------------------------------
3. DATABASE SETUP
------------------------------------------------------
Step 1: Open Database Manager
   - Open your browser and type: http://localhost/phpmyadmin

Step 2: Create Database
   - Click "New" on the left sidebar.
   - Database Name: halal_food_db
   - Click "Create".

Step 3: Import Data
   - Click on the "halal_food_db" database you just created.
   - Go to the "Import" tab at the top.
   - Click "Choose File" and select the "halal_food_db.sql" file included in this project folder.
   - Click "Import" (or "Go") at the bottom.

------------------------------------------------------
4. HOW TO RUN
------------------------------------------------------
Once the files are in `htdocs` and the database is imported:


* run Homepage on Browser:
  http://localhost/halal-food-website/frontend/index.php


*(Note: If you renamed the project folder, update "halal-food-website" in the URL to match your folder name).*

------------------------------------------------------
5. DEFAULT CREDENTIALS (TESTING)
------------------------------------------------------
Admin Login:
- Username: admin
- Password: 123

Customer Login:
- You can register a new account on the customer login page.

Note:
To change admin credentials open backend/reset-admin.php and set credentials according to you and
run it on Browser:
  http://localhost/halal-food-website/backend/reset-admin.php
 
*(Note: If you renamed the project folder, update "halal-food-website" in the URL to match your folder name).*

To Send mail, for replying as an admin to customer query

1. Enable 2-Step Verification
Google will not let you create an App Password unless your account is extra secure.

Go to your Google Account Settings.

On the left menu, click Security.

Under "How you sign in to Google," ensure 2-Step Verification is turned ON.

2. Generate the 16-Character App Password
In the search bar at the top of your Google Account page, type "App Passwords".

Select the result that says App Passwords.

App Name: Type something like "Fiverr Web Project" or "Halal Delights Website."

Click Create.

A yellow box will appear with a 16-character code (e.g., abcd efgh ijkl mnop).

In reply-message.php file, find: (
        $mail->Username   = 'username@gmail.com';     // <--- REPLACE THIS
        $mail->Password   = '0000000000000000';      // <--- PASTE YOUR 16-CHAR APP PASSWORD
        // ************************************************************

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipient
        $mail->setFrom('username@gmail.com', 'Halal Delights Admin'); // Change sender name if you want
)
Section and replace mail and app password.