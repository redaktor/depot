Depot
=====

Depot is a **PHP framework** for the **[Tent protocol][1]**. It manages data and
relationships for Tent entities and provides the foundation for **building Tent
clients** and **building Tent servers**.

Depot aims to be framework agnostic. One should be able to use Depot to embed
Tent server or Tent client functionality into any PHP application, whether the
application is built around Zend, Symfony, Silex, Aura, Laravel, Wordpress,
Drupal, or based on no framework at all.


Installation
------------

Through [Composer][2] as [depot/depot][3].

### If You Already Have Composer

    composer install --dev


### If You Need Composer

    curl -s https://getcomposer.org/installer | php
    php composer.phar install --dev


Testing
-------

To run the test suite,  execute the PHPUnit that was installed by Composer:

    vendor/bin/phpunit

*As of this writing there are no tests. Want to help out by writing some?*


License
-------

MIT, see LICENSE.


Community
---------

If you have questions or want to help out, join us in the
**#depot** or **#tent** channels on **irc.freenode.net**.


Not Invented Here
-----------------

There are a handful of other PHP implementations of the Tent protocol, notably
[TentPHP][4].

TentPHP ships with persistence via Doctrine DBAL, handles application
authorization and state, and handles user authentication and authorization. It
is streamlined for quickly rolling out a new Tent based client application with
less fuss.

Depot is more about making decisions on how you want to put your application
together. Depot also offers an API server interface in addition to an API client
interface.

TentPHP will definitely make a better base for many *client* apps. The benefits
are many and are spelled out quite clearly on the [TentPHP][4] project page.


[1]: https://tent.io
[2]: http://getcomposer.org
[3]: https://packagist.org/packages/depot/depot
[4]: https://github.com/beberlei/TentPHP
