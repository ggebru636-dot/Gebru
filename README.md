# Tigray Volleyball Federation

This repository contains a PHP + SQLite starter site for the Tigray Volleyball Federation.

Quick start (local):

1. Clone the repository and open in VS Code or terminal.

2. Ensure PHP is installed (PHP 7.4+ recommended).

3. Create writable runtime dirs:
   mkdir -p data uploads
   chmod 0777 data uploads

4. Start the built-in PHP server from the project root:
   php -S localhost:8000 -t .

5. Open http://localhost:8000 in your browser. The site will initialize the SQLite database on first run using inc/schema.sql.

6. Create the initial admin user and sample data by visiting:
   http://localhost:8000/admin/seed.php

   This creates an admin user with username "admin" and password "ChangeMe123!" — change the password after first login.

Notes:
- The site uses a file-based SQLite DB at data/database.sqlite. Add data/ and uploads/ to .gitignore if you don't want to commit runtime data.
- For production, host on a PHP-capable server and ensure the data/ and uploads/ directories are writable by the webserver.
- Contact form submissions are stored in the database and viewable via the SQLite DB. You can configure SMTP later to send email notifications.
