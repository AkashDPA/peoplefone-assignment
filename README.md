# Peoplefone Assignment Installation

## Prerequisites
- PHP 8.3 or higher
- Composer
- NPM
- Database (MySQL, PostgreSQL or Sqlite)

---

## Installation Steps

1. **Clone the repository**
   ```bash
   git clone git@github.com:AkashDPA/peoplefone-assignment.git
   cd assignment
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure your database**
   Edit the `.env` file with your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **seed dummy**
   ```bash
   php artisan db:seed
   ```

7. **Frontend dependencies**
   ```bash
   npm install && npm run dev
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

9. **Access the application**
   Open your browser and navigate to `http://localhost:8000`

---

## Admin Creds
   - Email: admin@gmail.com
   - Password: password
```
---

## Development Tools

This project includes Laravel Debugbar for development. Enable it in your `.env` file:
```
DEBUGBAR_ENABLED=true
```