# Multi-System Login Laravel Application

This repository contains two Laravel applications, `website-app` and `software-app`, implementing a Single Sign-On (SSO) system for developers and startups. The solution enables seamless authentication across both apps: logging into `website-app` automatically authenticates the user in `software-app`, and logging out from either app ensures logout from both. Each application features a login screen, a user dashboard, and a logout option, making it an ideal starting point for building secure, multi-system applications.

Designed with developers and startups in mind, this project is lightweight, scalable, and easy to customize, offering a cost-effective solution for implementing SSO without complex infrastructure. Whether you're a solo developer or a startup building a suite of applications, this project provides a robust foundation for shared authentication.

## Features
- **Single Sign-On (SSO)**: Shared authentication using a database session driver, allowing users to log in once and access both apps.
- **Login Screen**: Secure email/password authentication with validation and error handling.
- **User Dashboard**: Displays the logged-in user's name with a logout link.
- **Logout Sync**: Logging out from one app invalidates the session in both apps.
- **Shared Database**: Uses a single MySQL database (`task1`) for users and sessions, minimizing setup complexity.
- **Laravel Breeze**: Leverages Breeze for rapid authentication scaffolding and a clean UI.
- **Downloadable Package**: Easily downloadable as a zip for quick setup or distribution.

## Prerequisites
- **PHP**: 8.1 or higher
- **Composer**: Latest version
- **MySQL**: 5.7 or higher
- **Node.js and NPM**: Optional, for compiling frontend assets (e.g., CSS/JS)
- **Git**: For cloning the repository (optional if downloading as a zip)
- **Local Server**: Ability to run two Laravel instances (e.g., `php artisan serve` on ports 8000 and 8001)

## Downloading the Project
You can download the project in two ways:

1. **Clone via Git** (recommended for developers):
   ```bash
   git clone https://github.com/MohammadAliAbdullah/it-way-task1.git
   cd it-way-task1
   ```
2. **Download as Zip**:
   - Visit the repository on GitHub: `https://github.com/MohammadAliAbdullah/it-way-task1`.
   - Click the green "Code" button and select "Download ZIP".
   - Extract the zip file to a directory (e.g., `it-way-task1`).
   - Navigate to the extracted directory:
     ```bash
     cd it-way-task1
     ```

## Installation

### 1. Set Up the Database
1. **Create a MySQL Database**:
   ```bash
   mysql -u root -p
   CREATE DATABASE task1;
   ```
2. **Verify Database Access**:
   Ensure your MySQL user (e.g., `root`) has access to the `task1` database.

### 2. Set Up Website-App
1. **Navigate to Website-App**:
   ```bash
   cd website-app
   ```
2. **Install Dependencies**:
   ```bash
   composer install
   ```
3. **Copy Environment File**:
   ```bash
   cp .env.example .env
   ```
4. **Configure `.env`**:
   Update `.env` with your database credentials and settings:
   ```env
   APP_NAME=WebsiteApp
   APP_ENV=local
   APP_KEY=
   APP_DEBUG=true
   APP_URL=http://localhost:8000

   LOG_CHANNEL=stack

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=task1
   DB_USERNAME=root
   DB_PASSWORD=

   SESSION_DRIVER=database
   SESSION_CONNECTION=mysql
   SESSION_LIFETIME=120
   ```
5. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```
6. **Run Migrations**:
   Create the `users` and `sessions` tables in the `task1` database:
   ```bash
   php artisan migrate
   ```
7. **Compile Assets** (optional, for custom styling):
   ```bash
   npm install
   npm run dev
   ```
8. **Start the Server**:
   ```bash
   php artisan serve --port=8000
   ```

### 3. Set Up Software-App
1. **Navigate to Software-App**:
   ```bash
   cd ../software-app
   ```
2. **Install Dependencies**:
   ```bash
   composer install
   ```
3. **Copy Environment File**:
   ```bash
   cp .env.example .env
   ```
4. **Configure `.env`**:
   Update `.env` with the same database credentials as `website-app`:
   ```env
   APP_NAME=SoftwareApp
   APP_ENV=local
   APP_KEY=
   APP_DEBUG=true
   APP_URL=http://localhost:8001

   LOG_CHANNEL=stack

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=task1
   DB_USERNAME=root
   DB_PASSWORD=

   SESSION_DRIVER=database
   SESSION_CONNECTION=mysql
   SESSION_LIFETIME=120
   ```
5. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```
6. **Compile Assets** (optional):
   ```bash
   npm install
   npm run dev
   ```
7. **Start the Server**:
   ```bash
   php artisan serve --port=8001
   ```
   **Note**: Do not run `php artisan migrate` in `software-app` to avoid duplicating migrations, as the database is shared.

### 4. Testing the SSO Functionality
1. **Register a User**:
   - Visit `http://localhost:8000/register` in a browser.
   - Create a user (e.g., email: `test@example.com`, password: `password`).
2. **Test Login**:
   - Log in at `http://localhost:8000/login` with the registered credentials.
   - Navigate to `http://localhost:8001/dashboard` to verify the user is logged in without re-authentication.
3. **Test Logout**:
   - From `http://localhost:8000/dashboard`, click the "Logout" link.
   - Verify that `http://localhost:8001/dashboard` redirects to the login page.
   - Repeat by logging in at `http://localhost:8001/login` and logging out from `http://localhost:8001/dashboard`, then check `http://localhost:8000/dashboard`.
4. **Test Edge Cases**:
   - Enter invalid credentials at `http://localhost:8000/login` to ensure error messages display.
   - Test session expiration by waiting 120 minutes or deleting the session from the `sessions` table in the `task1` database.
   - Check browser console or Laravel logs (`website-app/storage/logs/laravel.log`, `software-app/storage/logs/laravel.log`) for SSO request errors.

## Project Structure
```
it-way-task1/
├── website-app/
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── Auth/AuthenticatedSessionController.php
│   │   │   │   ├── SSOController.php
│   │   │   │   ├── DownloadReadmeController.php
│   │   ├── Models/
│   │   │   ├── User.php
│   ├── config/
│   │   ├── cors.php
│   │   ├── session.php
│   ├── resources/
│   │   ├── views/
│   │   │   ├── auth/
│   │   │   │   ├── login.blade.php
│   │   │   ├── dashboard.blade.php
│   │   ├── css/
│   │   │   ├── app.css
│   ├── routes/
│   │   ├── web.php
│   ├── .env
│   ├── .env.example
├── software-app/
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── Auth/AuthenticatedSessionController.php
│   │   │   │   ├── SSOController.php
│   │   ├── Models/
│   │   │   ├── User.php
│   ├── config/
│   │   ├── cors.php
│   │   ├── session.php
│   ├── resources/
│   │   ├── views/
│   │   │   ├── auth/
│   │   │   │   ├── login.blade.php
│   │   │   ├── dashboard.blade.php
│   │   ├── css/
│   │   │   ├── app.css
│   ├── routes/
│   │   ├── web.php
│   ├── .env
│   ├── .env.example
├── .gitignore
├── README.md
```

## Customization
- **Authentication**:
  - Add fields to the `User` model (e.g., `role`) by modifying `app/Models/User.php` and updating migrations.
- **SSO Enhancements**:
  - For production, use Laravel Passport or an OAuth2 server for secure SSO.
  - Add API token validation for `/sso/login` and `/sso/logout` endpoints.

## Troubleshooting
- **Database Errors**:
  - Ensure MySQL is running and the `task1` database is accessible.
  - Verify `.env` credentials match your MySQL setup.
- **SSO Failures**:
  - Confirm both apps are running (`localhost:8000` and `localhost:8001`).
  - Check browser console or Laravel logs (`website-app/storage/logs/laravel.log`, `software-app/storage/logs/laravel.log`) for CORS or HTTP request errors.
  - Ensure the `sessions` table in the `task1` database contains valid session data.
- **Session Issues**:
  - Verify `SESSION_DRIVER=database` in both `.env` files.
  - Clear sessions with `php artisan session:clear` if issues arise.
- **Port Conflicts**:
  - If ports `8000` or `8001` are in use, choose alternatives (e.g., `8002`, `8003`) and update `.env` and controller URLs.

## License
This project is licensed under the MIT License. See the `LICENSE` file for details.

## Contact
For issues, feature requests, or support, create a GitHub issue or contact Mohammad Ali Abdullah via GitHub.
