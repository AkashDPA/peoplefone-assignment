# Peoplefone Assignment Installation

## Prerequisites
- PHP 8.3 or higher
- Composer
- Database (MySQL, PostgreSQL or Sqlite)

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


5. **seed dummy**
   ```bash
   php artisan db:seed
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

7. **Access the application**
   Open your browser and navigate to `http://localhost:8000`


## Development Tools

This project includes Laravel Debugbar for development. Enable it in your `.env` file:
```
DEBUGBAR_ENABLED=true
```