# SocialNet — CS451 Web Application Mock Project

A simple social network application built with **PHP**, **MySQL**, **Nginx**, and **Linux** (Docker).

## Tech Stack

| Component | Technology |
|-----------|-----------|
| Backend   | PHP 8.2 (PHP-FPM) |
| Database  | MySQL 8.0 |
| Web Server| Nginx (Alpine) |
| Container | Docker & Docker Compose |

## Quick Start

### Prerequisites
- [Docker](https://docs.docker.com/get-docker/) and [Docker Compose](https://docs.docker.com/compose/install/) installed.

### Run the application

```bash
# Clone the repository
git clone <your-github-repo-url>
cd cs451

# Copy the example environment file
cp .env.example .env

# Start all services
docker compose up -d --build

# The application will be available at:
# http://localhost:8888
```

### Stop the application

```bash
docker compose down

# To also remove the database volume:
docker compose down -v
```

## Default Admin Credentials

| Username | Password |
|----------|----------|
| admin    | password |

> Use the Admin page to create additional users.

## Application Pages

| Page | URL | Description |
|------|-----|-------------|
| Admin (Create User) | `/admin/newuser.php` | Create new user accounts |
| Sign In | `/socialnet/signin.php` | Login with existing account |
| Home | `/socialnet/index.php` | User info + list of all users |
| Settings | `/socialnet/setting.php` | Edit profile description |
| Profile | `/socialnet/profile.php` | View user profile (`?owner=username`) |
| About | `/socialnet/about.php` | Student name and ID |
| Sign Out | `/socialnet/signout.php` | Logout and redirect |

## Database

- **Database name**: `socialnet`
- **Table**: `account` with columns: `id`, `username`, `fullname`, `password`, `description`
- The `db.sql` file contains all SQL statements for database and table creation.

## Project Structure

```
cs451/
├── docker-compose.yml          # Docker orchestration
├── db.sql                      # Database initialization SQL
├── README.md                   # This file
├── nginx/
│   └── default.conf            # Nginx configuration
├── php/
│   └── Dockerfile              # PHP-FPM with MySQL extensions
└── src/
    ├── assets/
    │   └── style.css           # Application stylesheet
    ├── includes/
    │   ├── db.php              # Database connection helper
    │   ├── auth.php            # Authentication/session helper
    │   └── menubar.php         # Shared navigation bar
    ├── admin/
    │   └── newuser.php         # Admin: create user page
    └── socialnet/
        ├── index.php           # Home page
        ├── signin.php          # Sign-in page
        ├── signout.php         # Sign-out handler
        ├── profile.php         # User profile page
        ├── setting.php         # Settings page
        └── about.php           # About page
```

## Features

- Secure password hashing with bcrypt (`password_hash`)
- Prepared statements (PDO) to prevent SQL injection
- Session-based authentication
- Responsive dark theme UI
- Docker Compose for easy deployment
- XSS protection via `htmlspecialchars()`

## Student Info

- **Name**: Nguyen Ngoc Toan Thang
- **Student ID**: 1701830
