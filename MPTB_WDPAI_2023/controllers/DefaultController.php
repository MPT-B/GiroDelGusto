<?php

require_once 'AppController.php';
require_once 'SecurityController.php';
class DefaultController extends AppController
{
    private $restaurants = [];
    public function signup()
    {
        $this->render('signup');
        // if($this->isGet()){
        //     $this->render('signup');
        // }
    }
    public function login()
    {
        $this->render('login');
    }
    public function mainmenu()
    {
        $this->render('mainmenu', ['restaurants' => $this->restaurants]);
    }
    public function index()
    {
        $this->render('login');
    }
    public function restaurantlist()
    {
        $this->render('restaurantlist');
    }
    public function register()
    {
        $this->render('register');
    }
    public function userprofile()
    {
        $this->render('userprofile');
    }
    public function feed()
    {
        $this->render('feed');
    }
    public function map()
    {
        $this->render('map');
    }
    public function friends()
    {
        $this->render('friends');
    }
}
