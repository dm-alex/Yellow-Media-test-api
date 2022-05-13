# Yellow Media test api


## Instructions

```bash
composer install
cp .env.example .env
```
Setup APP_KEY, configure DB, MAIL driver

```bash
php artisan jwt:secret
php artisan migrate
```
