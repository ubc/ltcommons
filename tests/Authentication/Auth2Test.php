<?php
use UBC\SISAPI\Authentication\Auth2;

/**
 * @backupGlobals disabled
 */
class Auth2Test extends \PHPUnit_Framework_TestCase {
    private $auth;
    private $ticket = 'AVOUUb4DzzS6m0OrwncbEg@@';


    private $mockClient;

    private $rpcResponse;

    protected function setUp()
    {
        parent::setUp();

        $this->auth = new Auth2();
        $this->auth->setUsername('service_username');
        $this->auth->setPassword('service_password');
        $this->auth->setServiceUrl('https://www.auth.stg.id.ubc.ca');
        $this->auth->setServiceApplication('app_name');

        $value = new \XML_RPC_Value($this->ticket);
        $this->rpcResponse = new \XML_RPC_Response($value);
        $this->mockClient = $this->getMockBuilder('\XML_RPC_Client')
            ->setConstructorArgs(array('/auth/rpc', 'https://example.com'))
            ->getMock();

        $this->auth->setRpcClient($this->mockClient);
    }

    public function testGetHeader()
    {
        $this->mockClient->method('send')
            ->willReturn($this->rpcResponse);

        $this->assertEquals(array('Authorization' => $this->ticket), $this->auth->getHeader());
    }

    public function testGetHeaderWithCache()
    {
        $this->mockClient->expects($this->once())
            ->method('send')
            ->willReturn($this->rpcResponse);
        $this->auth->setTokenLifeTime(600);
        $this->auth->getHeader();
        // call again to use cached ticket
        $this->auth->getHeader();
    }

    /**
     * @expectedException RuntimeException
     */
    public function testGetHeaderException()
    {
        $this->mockClient->expects($this->once())
            ->method('send')
            ->willReturn(0);

        $this->auth->getHeader();
    }
}
 