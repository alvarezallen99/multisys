<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## API
http://127.0.0.1:8000/api/register
http://127.0.0.1:8000/api/login
http://127.0.0.1:8000/api/order

## Installation

1. copy .env.example to .env
2. create database with `multisys`
3. change the .env configuration according to your database credentials you created.
```
DB_DATABASE=multisys
DB_USERNAME=null
DB_PASSWORD=null
```
4. run this command
```
php artisan key:generate
php artisan jwt:secret
php artisan migrate --seed
```
5. Run server using this command:
```
php artisan serve --host=127.0.0.1 --port=8000
```

## Live Temporary Server
https://multisys.wixvpn.com

## Live Temporary API
https://multisys.wixvpn.com/api/register
https://multisys.wixvpn.com/api/login
https://multisys.wixvpn.com/api/order
