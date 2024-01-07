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

    public function getProperRestaurantList($userId, $town): array
    {
        $nearbyRestaurantsQuery = $this->query->getNearbyRestaurants($town);
        $bestInTownQuery = $this->query->getBestRestaurantsInTown($town);
        $userFavoritesQuery = $this->query->getUserFavoriteRestaurants($userId);

        $nearbyRestaurantsData = $this->fetchRestaurantsData($nearbyRestaurantsQuery);
        $bestInTownData = $this->fetchRestaurantsData($bestInTownQuery);
        $userFavoritesData = $this->fetchRestaurantsData($userFavoritesQuery);

        return [
            'nearbyRestaurants' => $this->createRestaurants($nearbyRestaurantsData),
            'bestInTown' => $this->createRestaurants($bestInTownData),
            'userFavorites' => $this->createRestaurants($userFavoritesData),
        ];
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
    public function addNewRestaurant($name, $address, $cityId, $cuisineId, $photoPath)
    {
        $this->database->beginTransaction();

        try {
            // Insert the new address
            $query = "INSERT INTO public.locations (address, city_id) VALUES (?, ?)";
            $stmt = $this->database->prepare($query);
            $stmt->execute([$address, $cityId]);

            // Get the ID of the new address
            $newLocationId = $this->database->lastInsertId();

            // Insert the new restaurant
            $query = "INSERT INTO public.restaurants (name, location_id, image_path) VALUES (?, ?, ?)";
            $stmt = $this->database->prepare($query);
            $stmt->execute([$name, $newLocationId, $photoPath]);

            // Get the ID of the new restaurant
            $newRestaurantId = $this->database->lastInsertId();

            // Insert the new cuisine type for the restaurant
            $query = "INSERT INTO public.restaurant_cuisines (restaurant_id, cuisine_type_id) VALUES (?, ?)";
            $stmt = $this->database->prepare($query);
            $stmt->execute([$newRestaurantId, $cuisineId]);

            // Commit the transaction
            $this->database->commit();
        } catch (Exception $e) {
            // An error occurred, rollback the transaction
            $this->database->rollBack();
            throw $e;
        }
    }
    public function getRestaurantByName(string $name): array
    {
        $query = $this->query->getRestaurantByNameQuery($name);
        $restaurantsData = $this->fetchRestaurantsData($query);
        return $this->createRestaurants($restaurantsData);
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
    public function getCities(): array
    {
        $query = $this->query->getCitiesQuery();
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        return $stmt->fetch() !== false;
    }

    public function removeFavorite($restaurantId, $userId)
    {
        $stmt = $this->database->prepare(
            'DELETE FROM favorite_restaurants WHERE user_id = :userId AND restaurant_id = :restaurantId'
        );

        $stmt->execute([':userId' => $userId, ':restaurantId' => $restaurantId]);
        return $stmt->fetch() !== false;
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
