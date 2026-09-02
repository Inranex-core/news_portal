# Comilla University Journalist Association (CoUJA) - News Portal

This is the official news portal for the Comilla University Journalist Association.

## Prerequisites

Before running this project, make sure you have the following installed:
- PHP (>= 8.1)
- Composer
- Node.js and NPM
- MySQL or SQLite

## How to Run the Project Locally

Follow these steps to set up and run the project on your local machine:

**1. Clone the repository (if you haven't already)**
```bash
git clone <repository-url>
cd news_portal
```

**2. Install PHP Dependencies**
```bash
composer install
```

**3. Install JavaScript Dependencies**
```bash
npm install
```

**4. Set up Environment Variables**
Copy the example environment file and create the `.env` file:
```bash
cp .env.example .env
```
Generate an application key:
```bash
php artisan key:generate
```

**5. Database Configuration**
Open the `.env` file and configure your database settings. For a quick start, you can use SQLite by setting:
```env
DB_CONNECTION=sqlite
# And remove or comment out DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
```
If using SQLite, create an empty `database.sqlite` file inside the `database` folder:
```bash
touch database/database.sqlite
```

**6. Run Migrations & Seeders**
Run the database migrations and optionally seed the database with initial data:
```bash
php artisan migrate --seed
```

**7. Compile Frontend Assets**
Run Vite to build your Tailwind CSS and JavaScript assets:
```bash
npm run build
# OR to watch for changes during development:
# npm run dev
```

**8. Start the Local Development Server**
```bash
php artisan serve
```

The application will now be available at: [http://localhost:8000](http://localhost:8000)

---

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
