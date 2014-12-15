<?php


namespace UBC\LtCommons\Provider;


class DataProviderFactory implements DataProviderFactoryInterface {
    protected $providers;

    public function __construct(array $providers = array())
    {
        $this->providers = $providers;
    }

    public function addProvider($provider)
    {
        $this->providers[get_class($provider)] = $provider;
    }

    public function getProvider($dataType)
    {
        $providerKey = null;

        foreach($this->providers as $class => $provider) {
            if ($class::doesProvide($dataType)) {
                $providerKey = $class;
                break;
            }
        }

        if (null == $providerKey) {
            throw new \RuntimeException(sprintf('No provider has been configured for data type %s', $dataType));
        }

        if (!$this->providers[$providerKey] instanceof DataProviderInterface) {
            $this->providers[$providerKey] = $this->createProvider($this->providers[$providerKey]);
        }

        return $this->providers[$providerKey];
    }

    private function createProvider(array $config)
    {
        if (!isset($config['class'])) {
            throw new \InvalidArgumentException(sprintf('"class" must be set in %s.', json_encode($config)));
        }
        if (!isset($config['arguments'])) {
            throw new \InvalidArgumentException(sprintf('"arguments" must be set in %s.', json_encode($config)));
        }

        $reflection = new \ReflectionClass($config['class']);

        return $reflection->newInstanceArgs($config['arguments']);
    }
}