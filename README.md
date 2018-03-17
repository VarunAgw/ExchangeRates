# Exchange Rates

## Introduction

Covert money into a different currency

## Installation

1. Run `composer install` to install dependencies

2. Copy `config/app.config.php` as `config/app.php` and fill database settings and Fixer.io api keys

3. Copy `dbv/config.php.sample` as `dbv/config.php` and fill database settings

4. Visit `http://localhost/dbv/` with default username/password as dbv/dbv. First pull all the schema into database and finally run `revision 0` to initialize tables with some data

5. Visit `http://localhost/` and your website is running perfectly now :)

## How do I get latest currencies available from the Fixer.io API and make them available to users?

There is a small shell script that get list of available currencies from fixer.io and save them into the database.

Simply run `php bin/cake.php currency refresh` and it will fetch the list of available currency from Fixer.io and update them into our database. Next time when user will visit our site, he/she will get complete list of new currencies.
