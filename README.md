# Inertia / Vue preset

A Laravel frontend preset for [inertiajs](https://inertiajs.com/) and [Vue](https://vuejs.org/).

## Titanium

[Titanium](https://usetitanium.com/) is a set of free/paid starter kits for Laravel.

## Installation

```
composer require inertiajs/inertia-laravel tightenco/ziggy laravel/ui usetitanium/inertia
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
