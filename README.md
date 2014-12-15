A Collection of UBC Data Service Library for Learning Applications
==================================================================
[![Build Status](https://travis-ci.org/ubc/ltcommons.png)](https://travis-ci.org/ubc/ltcommons)

Install
-------
```
composer require ubc/ltcommons
```

Usage
-----

### Plain PHP

```php
require 'vendor/autoload.php';

// Bootstrap the JMS custom annotations for Object to Json mapping
\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
    'JMS\Serializer\Annotation',
    dirname(__FILE__).'/vendor/jms/serializer/src'
);

$base_url = 'http://sisapi.example.com';
$username = 'service_username';
$password = 'service_password';

$providerFactory = new DataProviderFactory();
$providerFactory->addProvider(new SISDataProvider(
    $base_url,
    new GuzzleClient(),
    new BasicHttp($username, $password),
    new JMSSerializer()
));
$service = new DepartmentCodeService($providerFactory);
$codes = $service->getDepartmentCodes();

$student = $service->getStudentById('12345678');
```

### Using with Symfony 2

Please checkout [LtCommons bundle](https://github.com/ubc/ltcommons-bundle)

Run Tests
---------

```
composer install
vendor/bin/phpunit
```


