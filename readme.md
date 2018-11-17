## Prerequisite
-Composer (bind to php.exe for the server (XAMP/WAMP/etc...)) Use binary installation to be safe
-<a href="www.mailtrap.io">MailTrap</a> account (For Testing)

## Installation
- cd to the project directory in cpmmand prompt
- type in "composer install"

## Configuration
- Edit the .env file for DB_ & MAIL_ sections to your MySQL and MailTrap settings
- Edit public/core/database/connect.php file to your MySQL settings

## Send Mail
- Take note of the handle() function in app/Console/SendMail.php

### Manually Send Mail
-cd to the project directory in command prompt
-type "php artisan schedule:run" and enter

### Automatically Send Mail
Refer to <a href="https://stackoverflow.com/questions/36305146/how-to-run-task-scheduler-in-windows-10-with-laravel-5-1">StackOverflow</a>

### Send to Live Email (Gmail, OutLook, Yahoo Mail, etc...)
-Setup SMTP Server and modify the MAIL_ sections of the .env file