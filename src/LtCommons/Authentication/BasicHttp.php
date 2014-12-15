<?php
namespace UBC\LtCommons\Authentication;


/**
 * Class Basic http basic authentication implementation for auth module
 * @package UBC\LtCommons\Authentication
 */
class BasicHttp implements AuthInterface {
    private $username;
    private $password;

    public function __construct($username = '', $password = '')
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getHeader()
    {
        return array(
            'Authorization' => 'Basic ' . base64_encode(join(':', array($this->username, $this->password)))
        );
    }
}