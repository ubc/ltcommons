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
        $this->providers[] = $provider;
    }

    public function getProvider($dataType)
    {
        $supportProvider = null;

        foreach($this->providers as $k => $provider) {
            if (!$provider instanceof DataProviderInterface) {
                $this->providers[$k] = $provider = $this->createProvider($provider);
            }

            if ($provider::doesProvide($dataType)) {
                $supportProvider = $provider;
                break;
            }
        }

        if (null == $supportProvider) {
            throw new \RuntimeException(sprintf('No provider has been configured for data type %s', $dataType));
        }

        return $supportProvider;
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