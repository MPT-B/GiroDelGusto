<?php

require_once 'AppController.php';
require_once 'SecurityController.php';
require_once __DIR__ . '/../src/repository/RestaurantRepository.php';
require_once __DIR__ . '/../src/repository/ReviewRepository.php';

class DefaultController extends AppController
{
    private $securityController;

    public function __construct()
    {
        parent::__construct();
        $this->securityController = new SecurityController();
    }

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
    public function userReview()
    {
        $this->checkSession();
        $this->render('userReview');
    }
    public function userProfileSettings()
    {
        $this->checkSession();
        $this->render('userProfileSettings');
    }
    public function toggleFavorite()
    {
        $restaurantId = $_GET['restaurant_id'];
        $userId = $_GET['user_id'];

        $restaurantRepository = new RestaurantRepository();

        if ($restaurantRepository->isFavorite($restaurantId, $userId)) {
            $restaurantRepository->removeFavorite($restaurantId, $userId);
        } else {
            $restaurantRepository->addFavorite($restaurantId, $userId);
        }

        $this->redirectBack();
    }
    public function deleteReview()
    {
        $reviewId = $_GET['review_id'];
        $userId = $_GET['user_id'];

        $reviewRepository = new ReviewRepository();
        $userRepository = new UserRepository();
        $user = $userRepository->getUserById($userId);

        if ($reviewRepository->isReviewOwner($reviewId, $userId) || $user->getRole() == 'admin') {
            $reviewRepository->deleteReview($reviewId);
        }

        $this->redirectBack();
    }
    public function getRestaurantsByCuisine($cuisineType)
    {
        $restaurantRepository = new RestaurantRepository();
        $restaurants = $restaurantRepository->getRestaurantsByCuisine($cuisineType);

        header('Content-Type: application/json');
        echo json_encode($restaurants);
    }

    private function redirectBack()
    {
        $previousPage = $_SERVER['HTTP_REFERER'];
        header('Location: ' . $previousPage);
    }
    public function addReview()
    {
        $this->checkSession();

        $restaurantName = $_POST['restaurant-name'];
        $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0; // Default rating is 0
        $opinion = $_POST['opinion'];
        $food = $_POST['food'];

        $restaurantRepository = new RestaurantRepository();
        $restaurantId = $restaurantRepository->getRestaurantIdByName($restaurantName);

        if ($restaurantId !== null) {
            $userRepository = new UserRepository();
            $reviewRepository = new ReviewRepository();
            $user = $userRepository->getUserByEmail($_SESSION['email']);
            $userId = $user->getId();
            $reviewRepository->addReview($userId, $restaurantId, $rating, $opinion, $food);

            $this->redirectBack();
        } else {
            echo "Restaurant not found";
        }
    }
}
