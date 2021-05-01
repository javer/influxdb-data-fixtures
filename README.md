InfluxDB Data Fixtures
======================

The InfluxDB Data Fixtures is a library that provides data fixtures functionality for InfluxDB.

[![Build Status](https://github.com/javer/influxdb-data-fixtures/actions/workflows/test.yaml/badge.svg)](https://github.com/javer/influxdb-data-fixtures/actions/workflows/test.yaml)

Installation
============

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Open a command console, enter your project directory and execute:

```console
$ composer require javer/influxdb-data-fixtures
```

Usage
=====

Refer to the [Doctrine Data Fixtures Extension](https://github.com/doctrine/data-fixtures) documentation
about how to manage and execute the loading of data fixtures for the Doctrine ODM. 

To execute the InfluxDB fixtures:

```php
use Javer\InfluxDB\DataFixtures\Executor\MeasurementExecutor;
use Javer\InfluxDB\DataFixtures\Purger\MeasurementPurger;

$purger = new MeasurementPurger($measurementManager);
$executor = new MeasurementExecutor($measurementManager, $purger);
$executor->execute($loader->getFixtures());
```
