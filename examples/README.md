Depot Examples
==============

Depot is a PHP implementation of the [Tent][1] protocol. This
directory contains a small set of example applications to
showcase Depot's functionality.

These examples may become stale over time and will likely be
phased out as the codebase matures and there is actual
documentation and completed reference projects based on Depot.


Installation / Development
--------------------------

Depot is not currently available via [Packagist][2] but it is
managed by [Composer][3] to install dependencies.

To start working with the development version of Depot clone
this repository (or fork and clone) and run Composer install
with the `--dev` flag.

    composer install --dev

In theory the scripts in this directory should be able to be
run from anywhere. In practice it probably makes sense to run
them in one of two ways:

    # From the examples/ directory.
    cd examples
    php script.php

    # From the Depot project root director.
    php examples/script.php


Scripts
-------

In some cases order is not important. In some cases it is very
important. For client testing it is best to run `register-app.php`
first. This will ensure that the other scripts will be able to
actually connect to a target entity's server.

### register-app.php [entity_uri]

This script will discover `[entity_uri]` and attempt to register
and authorize an application with the entity's server. Example:

    php register-app.php https://depot-testapp.tent.is

The script will present the user with a URL to enter into a
browser. Visiting this URL should ask the user to accept authorization
for the application. After which the user will be redirected to a bogus
URL that contains a `code=` param and a `state=` param.

Copy and paste the value of the `code` param and `state` param into
the terminal as requested.

If everything has gone smoothly the script will display the application's
ID, its application level MAC credentials, and the application's
authorization MAC credentials.

The script will also write this information to `.tent-credentials.json`.
This file is read by some of the other example applications. This
acts as a very basic form of persistence. :)

**TODO:** We should persist the client application object as JSON as that
should be made trivial to do.


### check-app-registration.php

This script will perform some operations on a registered application
including doing a get on the application and putting changes to an
application.

A dump of the app response after putting a change to the app is displayed
as there is nothing really interesting or useful going on here. Nothing
that makes sense to display, anyway. :)


### check-profile-anonymous.php

This script will discover `[entity_uri]` and will present the user with a
list of profile types the entity has associated with it and the detailed
output of the basic and core profiles.

    php check-profile-anonymous.php https://depot-testapp.tent.is


Community
---------

If you have questions or want to help out, join us in the
**#depot** or **#tent** channels on **irc.freenode.net**.


[1]: https://tent.io
[2]: https://packagist.org
[3]: http://getcomposer.org/

