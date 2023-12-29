<?php

require_once 'AppController.php';
require_once 'SecurityController.php';
require_once __DIR__ . '/../src/repository/RestaurantRepository.php';
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
    public function toggle_favorite()
    {
        $restaurantId = $_GET['restaurant_id'];
        $userId = $_GET['user_id'];

        $restaurantRepository = new RestaurantRepository();

        if ($restaurantRepository->isFavorite($restaurantId, $userId)) {
            $restaurantRepository->removeFavorite($restaurantId, $userId);
        } else {
            $restaurantRepository->addFavorite($restaurantId, $userId);
        }

        $previousPage = $_SERVER['HTTP_REFERER'];
        header('Location: ' . $previousPage);
    }
}
