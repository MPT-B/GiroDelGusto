<?php
class User
{
    private $id;
    private $username;
    private $email;
    private $password;
    private $role;
    private $picturePath;
    private $bio;
    private $visitedPlaces;
    private $favoriteCuisines;

    public function __construct(string $username, string $email, string $password, string $picturePath, string $role = 'normal',)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->picturePath = $picturePath;
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
    public function getRole()
    {
        return $this->role;
    }
    public function getPicturePath()
    {
        return $this->picturePath;
    }
    public function getBio()
    {
        return $this->bio;
    }
    public function getVisitedPlaces()
    {
        return $this->visitedPlaces;
    }
    public function getFavoriteCuisines()
    {
        return $this->favoriteCuisines;
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
    public function setPicturePath($picturePath)
    {
        return $this->picturePath = $picturePath;
    }
    public function setBio($bio)
    {
        return $this->bio = $bio;
    }
    public function setVisitedPlaces($visitedPlaces)
    {
        return $this->visitedPlaces = $visitedPlaces;
    }
    public function setFavoriteCuisines($favoriteCuisines)
    {
        return $this->favoriteCuisines = $favoriteCuisines;
    }
}
