# Laravel 11 Installation Guide (Windows)

This guide walks you through the steps to install Laravel 11 from a GitHub repository on a Windows system.

## Prerequisites

Before starting, ensure you have the following installed on your system:

- [Git](https://git-scm.com/) - Version Control System
- [Composer](https://getcomposer.org/) - PHP Dependency Manager
- [PHP](https://www.php.net/downloads) - Version 8.1 or higher
- [Node.js](https://nodejs.org/) - For frontend dependencies (Optional for some projects)
- [Laravel 11 Requirements](https://laravel.com/docs/11.x/installation#server-requirements)
- A text editor or IDE (e.g., [VS Code](https://code.visualstudio.com/))
- [Laragon](https://laragon.org/) or [XAMPP](https://www.apachefriends.org/) for a local development environment

---

## Step 1: Clone the Repository

1. Open a terminal (Command Prompt, PowerShell, or Git Bash).
2. Navigate to the directory where you want to clone the repository.

```bash
cd path/to/your/projects
```

3. Clone the repository from GitHub:

```bash
git clone https://github.com/<your-repository-name>.git
```

Replace `<your-repository-name>` with the actual repository URL.

---

## Step 2: Navigate to the Project Directory

Once the repository is cloned, move into the project directory:

```bash
cd <your-project-folder>
```

---

## Step 3: Install PHP Dependencies

Run the following command to install the required PHP dependencies using Composer:

```bash
composer install
```

---

## Step 4: Configure the Environment

1. Copy the `.env.example` file to create a new `.env` file:

```bash
copy .env.example .env
```

2. Open the `.env` file in a text editor and update the necessary configurations, such as:

- `APP_NAME`
- `APP_URL`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`

3. Generate the application key:

```bash
php artisan key:generate
```

---

## Step 5: Set Up the Database

1. Create a new database using your preferred database management tool (e.g., phpMyAdmin, MySQL Workbench).
2. Update the `.env` file with your database credentials.
3. Run the migrations to set up the database schema:

```bash
php artisan migrate
```

---

## Step 6: Install Frontend Dependencies (Optional)

If the project uses frontend dependencies, run the following commands:

1. Install Node.js dependencies:

```bash
npm install
```

2. Compile assets:

```bash
npm run dev
```

---

## Step 7: Serve the Application

Start the Laravel development server:

```bash
php artisan serve
```

Open your browser and navigate to the application URL (e.g., `http://127.0.0.1:8000`).

---

## Troubleshooting

- **Missing PHP Extensions:** Ensure required extensions like `OpenSSL`, `PDO`, and `Mbstring` are enabled in your PHP configuration.
- **Permission Issues:** Verify write permissions for the `storage` and `bootstrap/cache` directories:

```bash
php artisan storage:link
```

- **Clear Caches:** If you encounter issues, clear caches:

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

---


## References

- [Laravel Documentation](https://laravel.com/docs/11.x)
- [Composer Documentation](https://getcomposer.org/doc/)
- [Node.js Documentation](https://nodejs.org/en/docs/)

Feel free to raise issues or contribute to this project!
