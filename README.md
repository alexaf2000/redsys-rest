[![Build Status](https://api.travis-ci.org/erusso7/redsys-rest.svg?branch=master)](https://travis-ci.org/erusso7/redsys-rest)
[![codecov](https://codecov.io/gh/erusso7/redsys-rest/branch/master/graph/badge.svg)](https://codecov.io/gh/erusso7/redsys-rest)


# Redsys REST
This is a simple library to use the RedSys service via the REST api.

Take a look to  [the official documentation](https://pagosonline.redsys.es/desarrolladores.html)

#### Requirements
* `php 7.3 or higher`
* `composer`
* `ext-openssl`
* `ext-json` (commonly already included)`

#### Usage:
Run in your terminal
```
$ composer require alexaf2000/redsys-rest
```

**NOTE:** You can find a complete example under the `examples` folder. 

#### Features

##### Already done:
* Refund ([see docs](https://pagosonline.redsys.es/funcionalidades-devolucion.html))

##### To-do:
* Authorization with already tokenized credit card
* Pre-Authorization
* Cancellation
* ....

### About the package

Based on erusso7/redsys-rest.
