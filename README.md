Depot
=====

Depot is a PHP framework for the [Tent protocol][1].


Installation
------------

Depot is not currently available via [Packagist][2] but it is
managed by [Composer][3] to install dependencies.

To start working with the development version of Depot clone
this repository (or fork and clone) and run Composer install
with the `--dev` flag.

### If You Already Have Composer

    composer install --dev


### If You Need Composer

    curl -s https://getcomposer.org/installer | php
    php composer.phar install --dev


Testing
-------

To run the test suite,  execute the PHPUnit that was installed
by Composer:

    vendor/bin/phpunit

*As of this writing there are no tests. Want to help out by
writing some?*


License
-------

MIT, see LICENSE.


Community
---------

If you have questions or want to help out, join us in the
**#depot** or **#tent** channels on **irc.freenode.net**.


[1]: https://tent.io
[2]: https://packagist.org
[3]: http://getcomposer.org

