# Laravel: Create a user from CLI with artisan

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=for-the-badge&logo=github)](LICENSE)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/spresnac/laravel-create-user-cli.svg?style=for-the-badge&logo=php)](https://packagist.org/packages/spresnac/laravel-create-user-cli)
[![Laravel Version](https://img.shields.io/badge/Laravel-%5E7%20|%20%5E8-important?style=for-the-badge&logo=laravel)](https://laravel.com)

[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/spresnac/laravel-create-user-cli/tests?label=GH%20Tests&logo=github&style=for-the-badge)](https://github.com/spresnac/laravel-create-user-cli/actions)  
![Codecov](https://img.shields.io/codecov/c/gh/spresnac/laravel-create-user-cli?logo=codecov&style=for-the-badge&token=6BEX55062B)  
[![StyleCI](https://github.styleci.io/repos/174492279/shield)](https://github.styleci.io/repos/174492279)  

---
# About this package 💡
This package is an easy way to create a user for a ci/cd workflow. Just setup your project as usual and create a new user by firing a cli-command.

---
# Installation 💻
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
---
# Usage 💪
This package is very simple to use, open up your console and type
```
php artisan user:create
```

When using it within some kind of continous deployment, use the parameter and options to get fully automated like
```
php artisan user:create "user_name" "user_email" "user_password" --force
```

One can get help with
```
php artisan help user:create
```
---
# CI environments
This is an overview of all result codes you can handle in ci environements:

Code | Description 
-----| --------------------------------------------------------------------------------------------------------------------
0    | all good 😃
1    | The user with this data is already existing and was not overwritten. Use the `--force` option to overwrite the user.
2    | There is a user exisiting with this data and there was a problem updating this database record.
5    | You should not get this code. If you do, you may have not provided all data correct.

---
# Tests 🤓
Start the tests like standard with
```
composer test-ci
```
or with
```
vendor/bin/phpunit
```
---
# Finally 🤩
... have fun ;)