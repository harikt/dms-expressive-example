## Usage

```
git clone https://github.com/harikt/example.web.expressive
cd example.web.expressive
composer install
mysql -u <username> -p dms < db.sql

php -S 0.0.0.0:8080 -t public public/index.php
```

Browse http://localhost:8080/dms .

update connection information on `config/container.php` .

mysql://root:password@localhost/dms

Sorry, I am lazy for not setting up the env variables now.

In a real world scenario many of the things in `config/container.php` will move to ConfigProvider.
