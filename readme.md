# Laravel: Create a user from CLI with artisan

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
![PHP from Packagist](https://img.shields.io/packagist/php-v/spresnac/laravel-create-user-cli.svg)
![Packagist](https://img.shields.io/packagist/l/spresnac/laravel-create-user-cli.svg)

# Installation
First things first, so require the package:

```
composer require spresnac/laravel-create-user-cli
```

Now, register the new command within your ``app\Console\Kernel.php``
```
    protected $commands = [
        \spresnac\createcliuser\CreateCliUserCommand::class,
    ];
```

# Usage
This package is very simple to use, open up your console and type
```
php artisan user:create
```

When using it within some kind of continous deployment, use the parameter and options to get fully automated like
```
php artisan user:create user_name user_email user_password --force
```

One can get help with
```
php artisan help user:create
```

# Finally
... have fun ;)