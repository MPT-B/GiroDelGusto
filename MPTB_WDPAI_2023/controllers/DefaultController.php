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

    public function renderPage($page)
    {
        $this->checkSession();
        $this->render($page);
    }

    public function renderLoginsPages($page)
    {
        $this->render($page);
    }

    public function toggleFavorite()
    {
        $data = $this->getJsonInput();
        $restaurantId = $data['restaurant_id'] ?? null;
        $userId = $data['user_id'] ?? null;

        if ($restaurantId === null || $userId === null) {
            $this->sendJsonResponse(['error' => 'Missing restaurant_id or user_id'], 400);
            return;
        }

        $restaurantRepository = $this->getRestaurantRepository();

        if ($restaurantRepository->isFavorite($restaurantId, $userId)) {
            $restaurantRepository->removeFavorite($restaurantId, $userId);
        } else {
            $restaurantRepository->addFavorite($restaurantId, $userId);
        }

        $this->sendJsonResponse(['isFavorite' => !$restaurantRepository->isFavorite($restaurantId, $userId)]);
    }

    public function getRestaurants()
    {
        $data = $this->getJsonInput();
        $userId = $data['userId'];
        $town = $data['town'];

        $restaurantRepository = $this->getRestaurantRepository();
        $restaurants = $restaurantRepository->getProperRestaurantList($userId, $town);

        $this->sendJsonResponse($restaurants);
    }
    public function isFavorite($restaurantId, $userId)
    {
        $restaurantRepository = $this->getRestaurantRepository();
        $isFavorite = $restaurantRepository->isFavorite($restaurantId, $userId);

        $this->sendJsonResponse(['isFavorite' => $isFavorite]);
    }
    public function addRestaurant()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $restaurantRepository = new RestaurantRepository();
            $name = $_POST['name'];
            // Check if a restaurant with the same name already exists
            if ($restaurantRepository->getRestaurantByName($name)) {
                $_SESSION['message'] = "A restaurant with this name already exists.";
                $this->redirectBack();
                exit; // Add this line
            }
            $address = $_POST['address'];
            $cityId = $_POST['city'];
            $cuisineId = $_POST['cuisine'];

            // Upload the photo
            $uploadDir = 'public/data/';
            $uploadFile = $uploadDir . basename($_FILES['photo']['name']);

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
                $_SESSION['message'] = "File is valid, and was successfully uploaded.";
            } else {
                $_SESSION['message'] = "Possible file upload attack!";
                $this->redirectBack();
                exit; // Add this line
            }

            // Add the new restaurant
            $restaurantRepository->addNewRestaurant($name, $address, $cityId, $cuisineId, '../../' . $uploadFile);
            $_SESSION['message'] = "Restaurant successfully added.";
            $this->redirectBack();
            exit; // Add this line
        }
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
    public function getRestaurantByName()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $restaurantName = $data['name'];

        $restaurantRepository = new RestaurantRepository();
        $restaurants = $restaurantRepository->getRestaurantByName($restaurantName);
        header('Content-Type: application/json');
        echo json_encode($restaurants);
    }

    public function getRestaurantsByCuisine()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $cuisineType = $data['cuisine_types'];

        $restaurantRepository = new RestaurantRepository();
        $restaurants = $restaurantRepository->getRestaurantsByCuisine($cuisineType);

        header('Content-Type: application/json');
        echo json_encode($restaurants);
    }
    private function redirectBack()
    {
        $previousPage = $_SERVER['HTTP_REFERER'] ?? "http://$_SERVER[HTTP_HOST]/mainmenu";
        header('Location: ' . $previousPage);
    }
    public function addReview()
    {
        $this->checkSession();

        $restaurantName = $_POST['restaurant-name'];
        $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
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
    private function getJsonInput()
    {
        return json_decode(file_get_contents('php://input'), true);
    }

    private function sendJsonResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    private function getRestaurantRepository()
    {
        return new RestaurantRepository();
    }
}
