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
```

## Update .env file

Open `.env` file and modify database, username and password according to yours.


## Migration


```bash
# Make migration script
./console dms:make:migration init

# Check status of migration
./console migrate:status

# Execute migration
./console migrate
```

## Browse

Start your webserver and enjoy DMS!.

```bash
php -S 0.0.0.0:8080 -t public public/index.php
```

Browse [http://localhost:8080/dms/auth/login](http://localhost:8080/dms/auth/login) .
