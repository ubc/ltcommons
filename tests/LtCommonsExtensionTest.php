<?php

class LtCommonsExtensionTest extends \PHPUnit_Framework_TestCase {

    public function testGet()
    {
        $container = new \Symfony\Component\DependencyInjection\ContainerBuilder();
        $extension = new \UBC\LtCommons\LtCommonsExtension();
        $container->registerExtension($extension);

        // ensure config is loaded, no need if using a config loader
        $container->loadFromExtension($extension->getAlias());

        // or loading from a config file
        //$loader = new YamlFileLoader($container, new FileLocator(__DIR__));
        //$loader->load(__DIR__.'/../config.yml');

        // compile the service definitions
        $container->compile();

        $this->assertInstanceOf('UBC\LtCommons\Service\DepartmentCodeService', $container->get('department_code'));
        $this->assertInstanceOf('UBC\LtCommons\Service\SubjectCodeService', $container->get('subject_code'));
    }
}
 