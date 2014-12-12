<?php
namespace UBC\LtCommons;


use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class LtCommonsExtension Dependency inject extension for LT Commons. This extension helps to
 * 1. Load the service definition file, services.yml
 * 2. Valid configuration
 * 3. Merge configuration file into default values in services.yml
 * @package UBC\LtCommons
 */
class LtCommonsExtension implements ExtensionInterface
{
    /**
     * Loads a specific configuration.
     *
     * @param array $config An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     *
     * @api
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
        $loader->load('services.yml');

        // process the array using the defined configuration
        $processor = new Processor();
        $configuration = new Configuration();
        try {
            $processedConfiguration = $processor->processConfiguration(
                $configuration,
                $config
            );

            // configuration validated
            //var_dump($processedConfiguration);
        } catch (\Exception $e) {
            // validation error
            echo $e->getMessage() . PHP_EOL;
        }

        // override the parameters in services.yml
        if (array_key_exists('Auth2', $processedConfiguration)) {
            $container->setParameter('config.username', $processedConfiguration['Auth2']['username']);
            $container->setParameter('config.password', $processedConfiguration['Auth2']['password']);
            $container->setParameter('config.service_application', $processedConfiguration['Auth2']['service_application']);
            $container->setParameter('config.service_url', $processedConfiguration['Auth2']['service_url']);
        }

        if (array_key_exists('SIS', $processedConfiguration)) {
            $container->setParameter('config.base_url', $processedConfiguration['SIS']['base_url']);
        }
    }

    /**
     * Returns the namespace to be used for this extension (XML namespace).
     *
     * @return string The XML namespace
     *
     * @api
     */
    public function getNamespace()
    {
        // TODO: Implement getNamespace() method.
    }

    /**
     * Returns the base path for the XSD files.
     *
     * @return string The XSD base path
     *
     * @api
     */
    public function getXsdValidationBasePath()
    {
        // TODO: Implement getXsdValidationBasePath() method.
    }

    /**
     * Returns the recommended alias to use in XML.
     *
     * This alias is also the mandatory prefix to use when using YAML.
     *
     * @return string The alias
     *
     * @api
     */
    public function getAlias()
    {
        return 'ltcommons';
    }
}