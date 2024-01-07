<?php
$userRepository = new UserRepository();
$restaurantRepository = new RestaurantRepository();

$user = $userRepository->getUserByEmail($_SESSION['email']);
$userId = $user->getId();

$town = 'Krakow';
$restaurants = $restaurantRepository->getAllRestaurants();
$nearbyRestaurants = $restaurantRepository->getNearbyRestaurants($town);
$bestInTown = $restaurantRepository->getBestRestaurantsInTown($town);
$userFavorites = $restaurantRepository->getUserFavoriteRestaurants($userId);

$data = [
    'nearbyRestaurants' => $nearbyRestaurants,
    'bestInTown' => $bestInTown,
    'userFavorites' => $userFavorites,
    'userId' => $userId, // Add the user ID to the data
];

header('Content-Type: application/json');
echo json_encode($data);
