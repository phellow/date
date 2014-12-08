This small library will help you to work with date/time specific objects.

## Install via Composer

Add the following dependency to your project's _composer.json_ file:

```json
{
    "require": {
        "phellow/date": "1.*"
    }
}
```

## Usage

Use the DateFactory to create all objects. You can add the factory to your Dependency Injection Container.

```php
$factory = new \Phellow\Date\DateFactory();

// create a DateTime object
$dt = $factory->createDateTime();
$dt = $factory->createDateTime('now');
$dt = $factory->createDateTime('2014-12-8');
$dt = $factory->createDateTime(time());
$dt = $factory->createDateTime($dt);

// create a Month object
$month = $factory->createMonth();
$month = $factory->createMonth('now');
$month = $factory->createMonth('2014-12-8');
$month = $factory->createMonth(time());
$month = $factory->createMonth($dt);
```

To see all the possibilities, you can check out the Unit Tests under _tests/_.

## License

The MIT license.