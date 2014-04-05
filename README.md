Robots.txt
=========

The original Robots class was written by *dragonfire1119* of TutsGlobal.com: <http://tutsglobal.com/topic/15-how-to-make-a-robotstxt-in-laravel-4/>

The class itself (`Robots.php`) will work on any PHP 5.3+ site. It could easily be modified for 5.2 by removing the namespace.

This repository offers easy integration via Composer and includes service provider and a facade for Laravel 4+ alongside a set of PHPUnit tests.

Checkout the `Robots.php` class for a full understanding of the functionality.

## Installation:

### Step 1. Downloading

As is usual with Composer packages, there are two ways to install Robots:

You can add class via Composer. Pick the "dev-master" as the version of the package.

    composer require healey/robots

Or add the following to your `composer.json` in the `require` section and then run `composer update` to install it.

    {
        "require": {
            "healey/robots": "dev-master"
        }
    }

### Step 2. Usage

#### PHP 5.3+

Create a script, or however you wish to do it, and create a .htaccess redirect to point to it. The script would look something like:

    <?php
    use Healey\Robots\Robots;

    $robots = new Robots();
    $robots->addUserAgent('*');
    $robots->addSitemap('sitemap.xml');

    header("HTTP/1.1 200 OK");
    echo $robots->generate();

#### Laravel

Once installed via Composer you need to add the service provider. Add the following to the 'providers' section of the app config (usually `app/config/app.php`):

    'Healey\Robots\RobotsServiceProvider',

The quickest way to use Robots is to just setup a callback-style route for `robots.txt` in your `/app/routes.php` file:

    <?php

    Route::get('robots.txt', function() {

        // If on the live server, serve a nice, welcoming robots.txt.
        if (app()->env === 'production')
        {
            Robots::addUserAgent('*');
            Robots::addSitemap('sitemap.xml');
        } else {
            // If you're on any other server, tell everyone to go away.
            Robots::addDisallow('*');
        }

        $response = Response::make(Robots::generate(), 200);
        $response->header('Content-Type', 'text/plain');

        return $response;
    });

And that's it! You can now show different robots.txt files on each environment without any additional code.

## License

MIT