# 🥛 Milk Admin Panel (Laravel)

A Laravel-based admin panel for managing milk delivery operations, including customer tracking, cow/buffalo milk logs, ghee & buttermilk sales, and detailed reporting.

## 🚀 Features

-   Customer management
-   Time-based milk delivery (Morning/Evening)
-   Product-wise reporting (Milk, Ghee, Buttermilk)
-   Monthly & annual reports
-   Dynamic rate management
-   AJAX-enabled forms & validations
-   Responsive admin dashboard

## 🧰 Requirements

-   PHP >= 8.2
-   Composer
-   Laravel >= 12
-   MySQL / MariaDB

## ⚙️ Installation

1. **Clone the repository**:

    ```bash
    git clone https://github.com/JaydipDabhi/milk-admin.git
    ```

2. **Navigate to the project folder**:

    ```
    cd milk-admin
    ```

3. **Install PHP dependencies**:
   This project uses Composer to manage PHP dependencies. To install them, run the following command:

    ```
    composer update
    ```

4. **Copy .env.example to .env**:
   The .env file contains environment-specific variables (such as your database configuration). Copy the contents of .env.example to a new .env file:

    ```
    cp .env.example .env
    ```

5. **Require Intervention Image 2.7 via Composer**:
   Run the following command in your terminal or command prompt:

    ```
    composer require intervention/image:2.7
    ```

6. **Includes Intervention Image with storage**:
   If your project includes file uploads or image handling with `Intervention Image`, you should include:

    ```
    php artisan storage:link
    ```

7. **Laravel DomPDF**:
   Require this package in your composer.json and update composer. This will download the package and the dompdf + fontlib libraries also.

    ```
    composer require barryvdh/laravel-dompdf
    ```

8. **Laravel DomPDF Configuration**:
   The defaults configuration settings are set in `config/dompdf.php`. Copy this file to your own config directory to modify the values. You can publish the config using this command:

    ```
    php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
    ```

9. **Generate application key**:
   Laravel requires an application key for encryption and other security purposes. Generate the application key by running:

    ```
    php artisan key:generate
    ```

10. **Run database migrations**:
    Laravel includes migrations to create the required database tables. Run the following command to set up the database schema:

    ```
    php artisan migrate
    ```

11. **Run the Laravel development server**:
    Start Laravel’s built-in development server by running:

    ```
    php artisan serve
    ```

---

Let me know if you want this personalized further with screenshots, badges, or a deployment section (like EC2 or cPanel instructions).
