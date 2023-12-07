<?php
class User
{
    private $username;
    private $email;
    private $password;

    public function __construct(string $username, string $email, string $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }
    public function getUserName()
    {
        return $this->username;
    }
    public function setUserName($username)
    {
        return $this->username = $username;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        return $this->email = $email;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        return $this->password = $password;
    }
}
