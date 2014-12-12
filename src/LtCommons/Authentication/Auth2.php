<?php
namespace UBC\LtCommons\Authentication;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Auth2 UBC CWL Auth2 client implementation for auth module
 * @package UBC\LtCommons\Authentication
 */
class Auth2 implements AuthModule, ConfigurationInterface
{
    const RPC_FUNC_NAME = 'applicationTransferSession';

    private $rpcClient;
    private $serviceUrl;
    private $serviceApplication;

    /**
     * @var service account username
     */
    private $username;
    /**
     * @var service account password
     */
    private $password;
    private $token;
    private $tokenTimestamp;
    private $tokenLifetime = 0;
    private $lastResponse;

    /**
     * @param mixed $rpcClient
     */
    public function setRpcClient($rpcClient)
    {
        $this->rpcClient = $rpcClient;
    }

    /**
     * @param string $serviceUrl
     */
    public function setServiceUrl($serviceUrl)
    {
        $this->serviceUrl = $serviceUrl;
    }

    /**
     * @param mixed $serviceApplication
     */
    public function setServiceApplication($serviceApplication)
    {
        $this->serviceApplication = $serviceApplication;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param mixed $tokenLifetime
     */
    public function setTokenLifetime($tokenLifetime)
    {
        $this->tokenLifetime = $tokenLifetime;
    }

    /**
     *
     */
    public function getHeader()
    {
        return array(
            'Authorization' => $this->getTicket()
        );
    }

    private function getTicket()
    {
        if ($this->isExpired())
        {
            $params = array(new \XML_RPC_Value($this->serviceApplication, 'string') );
            $msg = new \XML_RPC_Message("service.".self::RPC_FUNC_NAME, $params);

            $this->rpcClient->setCredentials($this->username, $this->password);

            $this->lastResponse = $this->rpcClient->send($msg);

            if (!$this->lastResponse)
            {
                throw new \RuntimeException("Communication error: [{$this->rpcClient->errstr}]");
            } else if ($this->lastResponse->faultCode() != 0) {
                // TODO: better exception throwing
                throw new \RuntimeException($this->lastResponse->faultString());
            }

            // update ticket and timestamp
            $this->token = XML_RPC_decode($this->lastResponse->value());
            $this->tokenTimestamp = time();

            return $this->token;
        } else {
            // use cached ticket if not expired
            return $this->token;
        }
    }

    private function isExpired()
    {
        return $this->tokenLifetime == 0 || time() > $this->tokenTimestamp + $this->tokenLifetime;
    }

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('Auth2');

        $rootNode
            ->children()
                ->scalarNode('username')
                    ->isRequired()
                ->end()
                ->scalarNode('password')
                    ->isRequired()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}