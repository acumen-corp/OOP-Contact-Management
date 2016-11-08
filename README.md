# Contact Management Application

[Phalcon PHP][1] is a web framework delivered as a C extension providing high
performance and lower resource consumption.

This is a sample application for the Phalcon PHP Framework. We expect to
implement as many features as possible to showcase the framework.

Please contact us if you have any feedback. www.acumensoftwaredesign.com

Thanks.

## NOTE

The master branch will always contain the latest stable version. If you wish
to check older versions or newer ones currently under development, please
switch to the relevant branch.

## Get Started

### Requirements

* PHP >= 5.6
* [Apache][2] Web Server with [mod_rewrite] enabled or [Nginx][4] Web Server
* Latest stable [Phalcon Framework release][5] extension enabled
* [MySQL][6] >= 5.1.5

###
###      A webserver running on your local machine or hosting provider
###      pointing to the domain listed in your /app/config/config.ini file.
####

### Installation

First you need to clone this repository:

```
$ git clone https://github.com/acumen-corp/OOP-Contact-Management.git
```

Then you'll need to create the database and initialize schema:

```sh
$ echo 'CREATE DATABASE invo CHARSET=utf8 COLLATE=utf8_unicode_ci' | mysql -u root
$ cat schemas/contact_management.sql | mysql -u root mysql
```

Also you can override application config by creating `app/config/config.ini.dev` (already gitignored).

## Contributing

See [CONTRIBUTING.md][7]

## License

© Phalcon Framework Team and contributors

[1]: https://phalconphp.com/
[2]: http://httpd.apache.org/
[3]: http://httpd.apache.org/docs/current/mod/mod_rewrite.html
[4]: http://nginx.org/
[5]: https://github.com/phalcon/cphalcon/releases
[6]: https://www.mysql.com/
