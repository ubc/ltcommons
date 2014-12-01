<?php
namespace UBC\SISAPI\Authentication;


/**
 * Class Basic http basic authentication implementation for auth module
 * @package UBC\SISAPI\Authentication
 */
class Basic implements AuthModule {
    private $username;
    private $password;

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