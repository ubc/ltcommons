<?php
// standard composer install vendor autoload magic
require dirname(__DIR__) . '/vendor/autoload.php';

// Bootstrap the JMS custom annotations for Object to XML/Json mapping
\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
'JMS\Serializer\Annotation',
dirname(__FILE__).'/../vendor/jms/serializer/src'
);

