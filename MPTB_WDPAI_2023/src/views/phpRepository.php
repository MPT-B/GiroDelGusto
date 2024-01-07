<?php
$userRepository = new UserRepository();
$restaurantRepository = new RestaurantRepository();
$reviewRepository = new ReviewRepository();



$user = $userRepository->getUserByEmail($_SESSION['email']);
$userId = $user->getId();
$restaurants = $restaurantRepository->getAllRestaurants();
$town = 'Krakow';
$cities = $restaurantRepository->getCities();
$cuisineTypes = $restaurantRepository->getCuisineTypes();
$friends = $userRepository->getFriendsByUserId($user->getId());
$nearbyRestaurants = $restaurantRepository->getNearbyRestaurants($town);
$bestInTown = $restaurantRepository->getBestRestaurantsInTown($town);
$userFavorites = $restaurantRepository->getUserFavoriteRestaurants($userId);
$userRole = $user->getRole();
$userProfile = $userRepository->getUserProfile($user->getId());
$feed = $reviewRepository->getUserFeed($userId);
