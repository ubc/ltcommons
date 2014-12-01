A Collection of UBC SIS API Services
====================================

Install
-------
```
composer require ubc/sisapi
```

Usage
-----
This library can be use with or without a dependency inject container. With a DI container, it is much easier to wire up all everything.

With DI container:
```php
require 'vendor/autoload.php';

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

// Bootstrap the JMS custom annotations for Object to Json mapping
\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
    'JMS\Serializer\Annotation',
    dirname(__FILE__).'/vendor/jms/serializer/src'
);

$container = new \Symfony\Component\DependencyInjection\ContainerBuilder();
$container->registerExtension(new \UBC\SISAPI\SISAPIExtension());

$loader = new YamlFileLoader($container, new FileLocator(__DIR__));
$loader->load('config.yml');

$container->compile();

$codes = $container->get('department_code')->getDepartmentCodes();
```

Without DI container, you will need to wire up all the components yourself, one by one:
```php
require 'vendor/autoload.php';

$config = new Config(
    'http://sisapi.example.com',
    'service_username',
    'service_password'
);

$serializer = new JMSSerializer();
$client = new GuzzleClient();
$auth = new Basic();
$auth->setUsername($config->getAuthUsername());
$auth->setPassword($config->getAuthPassword());
$service = new DepartmentCodeService($config, $client, $serializer, $auth);
$service->getDepartmentCodes();
```

Using with Symfony 2:
```php
```


Configuration
-------------

```yml
sisapi:
  Auth2:
    username: service_username 
    password: service_password 
    service_application: service_app
    service_url: https://www.auth.stg.id.ubc.ca

  SIS:
    base_url: http://sisapi.example.com
```

Run Tests
---------

```
composer install
vendor/bin/phpunit
```


