<?php

require_once 'AppController.php';
require_once 'SecurityController.php';
require_once __DIR__ . '/../src/repository/RestaurantRepository.php';
class DefaultController extends AppController
{

    public function signup()
    {
        $this->render('signup');
    }
    public function login()
    {
        $this->render('login');
    }
    public function mainmenu()
    {
        $this->checkSession();
        $this->render('mainmenu');
    }
    public function index()
    {
        $this->checkSession();
        $this->render('login');
    }
    public function restaurantlist()
    {
        $this->checkSession();
        $this->render('restaurantlist');
    }
    public function register()
    {
        $this->checkSession();
        $this->render('register');
    }
    public function userprofile()
    {
        $this->checkSession();
        $this->render('userprofile');
    }
    public function feed()
    {
        $this->checkSession();
        $this->render('feed');
    }
    public function map()
    {
        $this->checkSession();
        $this->render('map');
    }
    public function friends()
    {
        $this->checkSession();
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
    public function getRestaurantsByCuisine($cuisineType)
    {
        $restaurantRepo = new RestaurantRepository();
        $restaurants = $restaurantRepo->getRestaurantsByCuisine($cuisineType);

        header('Content-Type: application/json');
        echo json_encode($restaurants);
    }
}
