<?php

class BasicTest extends \PHPUnit_Framework_TestCase {
    protected $auth;

    protected function setUp()
    {
        parent::setUp();

        $this->auth = new \UBC\SISAPI\Authentication\Basic();
        $this->auth->setUsername('Aladdin');
        $this->auth->setPassword('open sesame');
    }

    public function testGetHeader()
    {
       $this->assertEquals(array('Authorization' => 'Basic QWxhZGRpbjpvcGVuIHNlc2FtZQ=='), $this->auth->getHeader());
    }
}
 