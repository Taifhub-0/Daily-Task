# Daily Tasks — CRUD Web App

## Overview
A simple task management web app built to practice PHP and database skills for the Web Technologies 2 course. Users can add, edit, delete, and track daily tasks with a status (Pending / Done) through a clean single-page interface backed by a SQLite database.

## Preview
![Daily Tasks UI](screenshots/preview.png)

## Features
- Add a new task with a name and status
- View all tasks in a table (ID, Task, Status, Actions)
- Edit or delete existing tasks
- Status badges (yellow = Pending, green = Done)


## Tech Stack
PHP 8.4 · SQLite · HTML · Bootstrap

## Files in This Repo
- `index.php` — main app logic: renders the UI, creates the tasks table if missing, and handles add/
- `db/DBConnection.php` — database connection class
- `db/myDB.db` — SQLite database file
- `composer.json` — project dependencies
- `screenshots/preview.png` — app UI screenshot


## How to Run
- Place the project folder in your local PHP server directory (e.g. XAMPP htdocs).
- Make sure the db/ folder is writable so SQLite can create/update myDB.db.
- Run with PHP's built-in server: php -S localhost:8000
- Open http://localhost:8000/index.php in your browser.


## License
MIT License - Feel free to use this for educational purposes.