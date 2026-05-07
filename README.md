# SocialNet Web Application

**SocialNet** is a secure, minimalist, and responsive web application built with PHP, MySQL, and Nginx. It operates within a fully containerized Docker environment, ensuring consistency and ease of deployment.

---

## Features

- **Authentication System:** Secure session-based login and logout mechanism using `password_hash` with bcrypt.
- **Role-Based Access Control (RBAC):** Distinct privileges for Administrators and regular Users.
  - **Admin:** Can create new users via a protected admin dashboard (`/admin/newuser.php`). Admins can see all users in the system.
  - **User:** Can update their own profile description and view other users' profiles. Users cannot see Administrator accounts on the main dashboard.
- **Minimalist UI/UX:** A highly refined, monochrome design language focusing on content clarity, structural borders, and excellent typography (Inter font).
- **Containerized Infrastructure:** Seamless deployment using Docker Compose, combining Nginx (Web Server), PHP-FPM (App Logic), and MySQL (Database).

---

## Prerequisites

To build and run this project, ensure you have `Docker` on your machine:

- [Docker Install](https://docs.docker.com/compose/install/) (available for Windows, MacOS, Linux)

---

## Build & Run Instructions

1. Open terminal, clone this repository to your local machine.
   ```bash
   git clone https://github.com/a-tt-om/CS451-SocialNet-Project.git
   ```
2. Navigate to the project directory:

   ```bash
   cd ./CS451-SocialNet-Project
   ```

3. Update .env file for production:

   ```bash
   cp .env.example .env
   ```

4. Build and start the Docker containers:

   ```bash
   docker compose up -d --build
   ```

5. To stop the application later and remove volumes, run:
   ```bash
   docker compose down -v
   ```

You can interact with the shell of each container to test and debug by running:

```bash
docker compose exec <container_name> sh
```

Or via [Docker Desktop](https://www.docker.com/products/docker-desktop/)

For more information on Docker operations and usage, please refer to the [Docker Documentation](https://docs.docker.com/manuals/)

---

## Accessing the Application

Once the containers are successfully running, you can access the application via your web browser:
[http://localhost:8888/](http://localhost:8888/)

---

## Default Credentials

The database is automatically seeded upon initialization with the following accounts for testing and grading purposes:

### 1. Administrator Account

Use this account to test administrative capabilities (like creating new users and viewing all accounts on the home page).

- **Username:** `admin`
- **Password:** `admin`
- **Fullname:** Toàn Thắng

### 2. Regular User Accounts

Use these accounts to test normal user visibility rules (e.g., cannot see the Admin on the Home page, cannot access the Create User page). There are 5 test accounts with identical username/password pairs:

- **Username:** `test1` | **Password:** `test1`
- **Username:** `test2` | **Password:** `test2`
- **Username:** `test3` | **Password:** `test3`
- **Username:** `test4` | **Password:** `test4`
- **Username:** `test5` | **Password:** `test5`

---

## Project Structure

```text
├── .env                 # Environment variables for Docker configuration
├── docker-compose.yml   # Docker multi-container orchestration file
├── README.md            # This documentation file
├── mysql/
│   ├── Dockerfile       # Database container setup
│   └── init.sql         # Database schema and seed data (runs on startup)
├── nginx/
│   ├── Dockerfile       # Web server container setup
│   └── default.conf     # Nginx routing configuration
├── php/
│   └── Dockerfile       # PHP-FPM container with PDO MySQL extensions
└── src/
    ├── admin/           # Admin-protected endpoints (newuser.php)
    ├── assets/          # Static assets (style.css, fonts, etc.)
    ├── includes/        # Shared backend logic (auth.php, db.php, menubar.php)
    └── socialnet/       # Core application pages (index, signin, profile, etc.)
```
