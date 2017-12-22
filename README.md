# Quick demo

[YouTube](https://www.youtube.com/watch?v=hMtGHVgYhmE) .

<p align="center">
    <a href="https://www.youtube.com/watch?v=hMtGHVgYhmE">
        <img src="https://img.youtube.com/vi/hMtGHVgYhmE/0.jpg" alt="Integrating DMS with Zend Expressive" />
    </a>
</p>

## Usage

```bash
git clone https://github.com/harikt/dms-expressive-skeleton
cd dms-expressive-skeleton
composer install

# copy env and modify username / password and database name
cp env.example .env

# Copy dms configuration manually for now.
cp vendor/harikt/web.expressive/config/dms.php config/autoload/dms.global.php

# Create data folder which can save cache files
mkdir -p data/cache/blade
chmod -R 755 data/cache/blade

# Create migrations folder
mkdir -p database/migrations

# Make migration script
./console dms:make:migration init

# Check status of migration
./console migrate:status

# Execute migration
./console migrate

# Start your web server
php -S 0.0.0.0:8080 -t public public/index.php
```

Browse [http://localhost:8080/dms/auth/login](http://localhost:8080/dms/auth/login) .
