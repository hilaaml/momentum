# Momentum

Organize your tasks, track every minute, generate insightful reports, and see your productivity soar — all in one beautiful dashboard.

## Core Features

- **Projects & Tasks** – Create projects and track tasks with toggleable completion status
- **Time Tracking** – Start/stop timers with one click
- **Productivity Analytics** – Track performance with streaks, heatmaps, and filterable reports by day, hour, and project
- **Daily Journal** – Document your progress with searchable entries and calendar view

## Tech

- Backend: Laravel 10 (PHP 8.1+)
- Frontend: Tailwind CSS + Alpine.js
- Database: MySQL/MariaDB

## Quick Start

```powershell
# 1. Clone the repo
git clone https://github.com/hilaaml/momentum.git
cd momentum

# 2. Copy environment file & generate key
copy .env.example .env
php artisan key:generate

# 3. Install dependencies
composer install --optimize-autoloader
npm install
npm run build

# 4. Setup database
php artisan migrate --seed
```

## Development

```powershell
# Run in separate terminals
npm run dev
php artisan serve
```

Visit http://127.0.0.1:8000 in your browser

Login with:
- Email: dev@mail.com
- Password: dev

## License

MIT