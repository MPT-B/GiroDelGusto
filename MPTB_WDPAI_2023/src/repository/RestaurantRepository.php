<?php
require_once 'Repository.php';
require_once __DIR__ . '/../../models/Restaurant.php';

class RestaurantRepository extends Repository
{
    public function __construct()
    {
        $query = new Query();
        parent::__construct($query);
    }
    // public function getRestaurant(): array
    // {
    //     $restaurantsData = $this->fetchRestaurantsData();
    //     return $this->createRestaurants($restaurantsData);
    // }
    public function getProperRestaurantList(): array
    {
        $query = $this->query->getRestaurantsQuery();
        $restaurantsData = $this->fetchRestaurantsData($query);
        return $this->createRestaurants($restaurantsData);
    }
    private function createRestaurants(array $restaurantsData): array
    {
        $restaurants = [];

        foreach ($restaurantsData as $restaurantData) {
            $restaurants[] = new Restaurant(
                $restaurantData['id'],
                $restaurantData['name'],
                $restaurantData['address'],
                $restaurantData['average_rating'],
                $restaurantData['number_of_reviews'],
                $restaurantData['cuisine'],
                $restaurantData['image_path'],
                $restaurantData['city']
            );
        }

        return $restaurants;
    }
    public function getRestaurantIdByName(string $name): ?int
    {
        $stmt = $this->database->prepare($this->query->getRestaurantIdByNameQuery());
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();

        $restaurant = $stmt->fetch(PDO::FETCH_ASSOC);

        return $restaurant ? $restaurant['id'] : null;
    }
    private function fetchRestaurantsData($query): array
    {
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllRestaurants(): array
    {
        $query = $this->query->getRestaurantsQuery();
        $restaurantsData = $this->fetchRestaurantsData($query);
        return $this->createRestaurants($restaurantsData);
    }
    public function getRestaurantsByCuisine($cuisineType): array
    {
        $query = $this->query->getRestaurantsByCuisine($cuisineType);
        $restaurantsData = $this->fetchRestaurantsData($query);
        return $this->createRestaurants($restaurantsData);
    }

    public function getUserFavoriteRestaurants($userId): array
    {
        $query = $this->query->getUserFavoriteRestaurants($userId);
        $restaurantsData = $this->fetchRestaurantsData($query);
        return $this->createRestaurants($restaurantsData);
    }

    public function getNearbyRestaurants($userLocation): array
    {
        $query = $this->query->getNearbyRestaurants($userLocation);
        $restaurantsData = $this->fetchRestaurantsData($query);
        return $this->createRestaurants($restaurantsData);
    }

    public function getBestRestaurantsInTown($town): array
    {
        $query = $this->query->getBestRestaurantsInTown($town);
        $restaurantsData = $this->fetchRestaurantsData($query);
        return $this->createRestaurants($restaurantsData);
    }
    public function isFavorite($restaurantId, $userId)
    {
        $query = $this->query->isFavorite($restaurantId, $userId);
        $stmt = $this->database->prepare($query);
        $stmt->execute([':userId' => $userId, ':restaurantId' => $restaurantId]);
        return $stmt->fetch() !== false;
    }
    public function addFavorite($restaurantId, $userId)
    {
        $stmt = $this->database->prepare(
            'INSERT INTO favorite_restaurants (user_id, restaurant_id) VALUES (:userId, :restaurantId)'
        );

        $stmt->execute([':userId' => $userId, ':restaurantId' => $restaurantId]);
    }

    public function removeFavorite($restaurantId, $userId)
    {
        $stmt = $this->database->prepare(
            'DELETE FROM favorite_restaurants WHERE user_id = :userId AND restaurant_id = :restaurantId'
        );

        $stmt->execute([':userId' => $userId, ':restaurantId' => $restaurantId]);
    }

    public function getCuisineTypes(): array
    {
        $stmt = $this->database->prepare(
            'SELECT * FROM cuisine_types'
        );

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
