<?php
class User
{
    private $id;
    private $username;
    private $email;
    private $password;
    private $role;

    public function __construct(string $username, string $email, string $password, string $role = 'normal')
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getUserName()
    {
        return $this->username;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setUserName($username)
    {
        return $this->username = $username;
    }
    public function setEmail($email)
    {
        return $this->email = $email;
    }
    public function setPassword($password)
    {
        return $this->password = $password;
    }
    public function setId($id)
    {
        return $this->id = $id;
    }
    public function setRole($role)
    {
        return $this->role = $role;
    }
    public function getRole()
    {
        return $this->role;
    }
}
