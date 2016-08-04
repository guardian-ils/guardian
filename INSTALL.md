# Install Instructions

These steps are tested for Linux. If you're using Mac or Windows, we don't offically support them yet. Sorry.

-------

## Requirement
- A Unix-Like Operation System (e.g. Linux, BSD, Unix)
- Access of super account (i.e. root) or permission to
  use `sudo` command
- Java 7 or above

-------

## Softwares that would be installed
- Nginx
- PostgreSQL 9.4+
- ElasticSearch
- PHP 5.5+ or HHVM 3.12+

-------

## Prepare Dependencies

### 1. Install the Software Depenencies

#### Ubuntu

##### Ubuntu 14.04

Ubuntu 14.04 provides PHP 5.5 by default. However, you'd need PPA to properly
install PosgreSQL. You can simply run the command below:

```
sudo sh -c 'echo "deb http://apt.postgresql.org/pub/repos/apt/ $(lsb_release -cs)-pgdg main" > /etc/apt/sources.list.d/pgdg.list'
wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | sudo apt-key add -
sudo apt-get update
sudo apt-get upgrade
sudo apt-get install -y php5-fpm nginx postgresql-9.4 openjdk-7-jre
```

##### Ubuntu 16.04

Ubuntu 16.04 provides PHP 5.5 and PostgreSQL 9.4 by default. You don't need to
use PPA anymore.

```
sudo apt-get update
sudo apt-get install -y php5-fpm nginx postgresql-9.4 openjdk-7-jre
```


### 2. Create and Configure PostgreSQL database
Find out your PostgreSQL superuser (It is usually `postgres`
in default distro installation). Switch to the user. Then
create your database.

The below steps assumes your Linux is using `sudo`
permission model. If not, just login to root and run them.

```
export DB_USER="some_username"
export DB_NAME="some_db_name"
sudo su - postgres
createuser "$DB_USER"
createdb "$DB_NAME"
psql -c "GRANT ALL ON \"$DB_NAME\" TO \"$DB_USER\""
psql "$DB_NAME" -c 'CREATE EXTENSION "uuid-ossp";'
exit
```


### 3. Install ElasticSearch

(TBD)


-------

## Install Guardian

### 1. Clone this repository

Run this command
```
git clone https://github.com/guardian-ils/Guardian.git
cd Guardian
```


### 2. Configure Laravel environment

Edit copy the [.env.example](.env.example) file as `.env`.
```
cp .env.example .env
```

Edit the `.env` file.

Set `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
to fit the database setup you created in step 1. Save it.

```
APP_ENV=local
APP_DEBUG=false
APP_KEY=SomeRandomString
APP_LOG=errorlog

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_DATABASE=guardian
DB_USERNAME=guardian
DB_PASSWORD=secret
DB_SCHEMA=public

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

MAIL_DRIVER=mailgun
```


### 3. Run composer and artisan installation commands

Run these commands
```
composer install
php artisan key:generate
php artisan migrate
```


### 4. Setup your Nginx

Setup your Nginx so it can show Guardian correctly.

Please reference this recipe for Nginx Setup:
- [http://laravel-recipes.com/recipes/26/creating-a-nginx-virtualhost](Creating a Nginx VirtualHost)


### 5. Browse the site on browser

To verify the installation, please check in the browser
that you can correctly see the site.

Should you find any issue, please file a bug report in
our [issue tracker](https://github.com/guardian-ils/Guardian/issues).
