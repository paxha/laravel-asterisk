<p align="center">
    <a href="https://packagist.org/packages/paxha/laravel-asterisk">
        <img src="https://img.shields.io/packagist/dt/paxha/laravel-asterisk" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/paxha/laravel-asterisk">
        <img src="https://img.shields.io/packagist/v/paxha/laravel-asterisk" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/paxha/laravel-asterisk">
        <img src="https://img.shields.io/packagist/l/paxha/laravel-asterisk" alt="License">
    </a>
</p>

## Introduction

Laravel Asterisk provides a Docker powered local development experience for Asterisk in Laravel that is compatible with
macOS, Windows (WSL2), and Linux. Other than Docker, no software or libraries are required to be installed on your local
computer before using Laravel Asterisk.

> **Note:** This package is considering you are using `sail` or `docker`.

## Installation

```shell
composer require paxha/laravel-asterisk
```

## Configuration

You have to simply add a service in `docker-compose.yml`.

```
services:    
    asterisk:
        build:
            context: ./vendor/paxha/laravel-asterisk/runtimes
            dockerfile: Dockerfile
            args:
                UDP_PORT: '${UDP_PORT:-5060}'
                MYSQL_PORT: '${FORWARD_DB_PORT:-3306}'
                MYSQL_DATABASE: '${DB_DATABASE}'
                MYSQL_USER: '${DB_USERNAME}'
                MYSQL_PASSWORD: '${DB_PASSWORD}'
        image: laravel-asterisk:19
        ports:
            - '${UDP_PORT:-5060}:5060/udp'
        volumes:
            - './vendor/paxha/laravel-asterisk/config:/etc/asterisk'
        networks:
            - sail
        depends_on:
            - mysql 
```

And then

```shell
sail up -d
```

To publish the asterisk configuration for i.e. `/etc/asterisk`

```shell
sail artisan asterisk:install
```

You will see the directory for asterisk configurations and modify according to your requirement.

```
asterisk
│   
└───config
    │   asterisk.conf
    │   modules.conf
    │   res_odbc.conf
    │   ...
```

## License

Laravel Asterisk is open-sourced software licensed under the [MIT license](LICENSE.md).
