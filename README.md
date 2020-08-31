# Inertia / Vue preset

A Laravel frontend preset for [inertiajs](https://inertiajs.com/) and [Vue](https://vuejs.org/).

## Titanium

[Titanium](https://usetitanium.com/) is a set of free/paid starter kits for Laravel.

## Installation

```
composer require inertiajs/inertia-laravel tightenco/ziggy laravel/ui titanium/inertia
php artisan ui inertia
npm install
npm run dev
```

## Options

### Auth

To scaffold authentication use the `--auth` flag.

```
php artisan ui inertia --auth
```

### Adapter

To specify which client-side adapter you are using for Inertia use the `--option` parameter.

Currently `vue` and `react` are supported.

```
php artisan ui inertia --option vue
```

## Laravel's authentication options

With Laravel's default authentication it's possible to enable things like email verification and password confirmation. This is also possible using this preset.

### Email verification

Email verification with Inertia works the exact same way as it does in the default Laravel authentication package. It requires a few changes to the `User` model and to the database table. Follow the steps in the [official Laravel documentation](https://laravel.com/docs/7.x/verification) to see which changes needs to be implemented.

The email verification view is included in this kit.

### Password confirmation

The password confirmation view is included in this kit.

To enable password confirmation for a sensitive route add the `password.confirm` middleware.

```php
Route::get('/secret-route', function () {
    //
})->middleware(['auth', 'password.confirm']);
```
