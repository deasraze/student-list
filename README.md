# Student List
This is a small application that supports data creation, reading, and updating operations, designed using the MVC architectural pattern.

## Requirements
- PHP >= 7.4
- [Composer](https://getcomposer.org/)
- [MariaDB](https://mariadb.org/) or [MySQL](https://www.mysql.com/)
- Web server that supports URL rewriting

## Technologies used
- PSR-4 autoloader from the composer
- [Bootstrap 5](https://getbootstrap.com/)

## Installation Guide
1. Clone the repository using the command `git clone https://github.com/theifel/student-list.git`
2. Install the composer autoloader `composer install`
3. Set directory `/path/to/student-list/web` as a document root of your web server
4. See the [guide](https://github.com/theifel/student-list/blob/main/web-server.md) for setting up your web server
5. Set your settings in the `App/config/db_params.json` file for connecting to the database, for example:
```json
{
  "db": {
    "host": "localhost",
    "dbname": "studentsDB",
    "user": "your_user",
    "password": "user_password",
    "charset": "utf8mb4"
  }
}
```
6. Import the `database.sql` file to your MariaDB or MySQL database

## License
The Student List app is open-sourced software licensed under the [MIT license](https://github.com/theifel/student-list/blob/main/LICENSE.md).