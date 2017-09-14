## Usage

```bash
git clone https://github.com/harikt/example.web.expressive
cd example.web.expressive
composer install

# Import database, currently no migration
mysql -u <username> -p database < db.sql

# copy env and modify username / password and database name
cp env.example .env

# Start your web server
php -S 0.0.0.0:8080 -t public public/index.php
```

Browse http://localhost:8080/dms .

In a real world scenario many of the things in `config/container.php` will move to  ConfigProvider.
