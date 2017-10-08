## Quick demo

[YouTube](https://www.youtube.com/watch?v=hMtGHVgYhmE) .

<p align="center">
    <a href="https://www.youtube.com/watch?v=hMtGHVgYhmE">
        <img src="https://img.youtube.com/vi/hMtGHVgYhmE/0.jpg" alt="Integrating DMS with Zend Expressive" />
    </a>
</p>

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

> Templates not rendered due to Permission issues. Quick and dirty fix.

```
mkdir -p data/cache/blade
sudo chmod -R 755 data/cache/blade
```
