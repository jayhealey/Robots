Robots.txt Generator for Laravel
=========
[![Build Status](https://travis-ci.org/jayhealey/Robots.svg?branch=master)](https://travis-ci.org/jayhealey/Robots)

The original Robots class was written by *dragonfire1119* of TutsGlobal.com: <http://tutsglobal.com/topic/15-how-to-make-a-robotstxt-in-laravel-4/>

The class itself (`Robots.php`) will work on any PHP 5.3+ site. It could easily be modified for 5.2 by removing the namespace.

This repository offers easy integration via Composer and includes service provider and a facade for Laravel 4+ alongside a set of PHPUnit tests.

Checkout the `Robots.php` class for a full understanding of the functionality.

## Installation:

### Step 1. Downloading

As usual with Composer packages, there are two ways to install:

You can install via Composer. Pick the "master" as the version of the package.

    composer require healey/robots

Or add the following to your `composer.json` in the `require` section and then run `composer update` to install it.

```js
{
    "require": {
        "healey/robots": "dev-master"
    }
}
```

### Step 2. Usage

#### Laravel

Once installed via Composer you need to add the service provider. Do this by adding the following to the 'providers' section of the application config (usually `app/config/app.php`):

```php
'Healey\Robots\RobotsServiceProvider',
```

Note that the facade allows you to use the class by simply calling `Robots::doSomething()`.

The quickest way to use Robots is to just setup a callback-style route for `robots.txt` in your `/app/routes.php` file.

```php
<?php

Route::get('robots.txt', function() {

    // If on the live server, serve a nice, welcoming robots.txt.
    if (App::environment() == 'production')
    {
        Robots::addUserAgent('*');
        Robots::addSitemap('sitemap.xml');
    } else {
        // If you're on any other server, tell everyone to go away.
        Robots::addDisallow('*');
    }

    return Response::make(Robots::generate(), 200, array('Content-Type' => 'text/plain'));
});
```

#### PHP 5.3+

Add a rule in your `.htaccess` for `robots.txt` that points to a new script/template/controller/route/etc.

The code would look something like:

```php
<?php
use Healey\Robots\Robots;

$robots = new Robots();
$robots->addUserAgent('*');
$robots->addSitemap('sitemap.xml');

header("HTTP/1.1 200 OK");
echo $robots->generate();
```

And that's it! You can show different `robots.txt` files depending on how simple or complicated you want it to be.

## License

MIT
