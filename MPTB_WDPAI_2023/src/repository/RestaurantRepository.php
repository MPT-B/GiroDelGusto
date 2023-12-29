<?php
require_once 'Repository.php';
require_once __DIR__ . '/../../models/Restaurant.php';

class RestaurantRepository extends Repository
{
    public function getRestaurant(): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare(
            '
            SELECT r.id, r.name, l.address, ci.name as city, string_agg(DISTINCT c.type, \', \') as cuisine, ROUND(CAST(AVG(rev.rating) as numeric), 1) as average_rating, COUNT(rev.id) as number_of_reviews, r.image_path
            FROM restaurants r
            INNER JOIN locations l ON r.location_id = l.id
            INNER JOIN cities ci ON l.city_id = ci.id
            INNER JOIN restaurant_cuisines rc ON r.id = rc.restaurant_id
            INNER JOIN cuisine_types c ON rc.cuisine_type_id = c.id
            LEFT JOIN reviews rev ON r.id = rev.restaurant_id
            GROUP BY r.id, r.name, l.address, ci.name, r.image_path;
            '
        );

        $stmt->execute();
        $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($restaurants as $restaurant) {
            $result[] = new Restaurant(
                $restaurant['name'],
                $restaurant['address'],
                $restaurant['average_rating'],
                $restaurant['number_of_reviews'],
                $restaurant['cuisine'],
                $restaurant['image_path'],
                $restaurant['city']
            );
        }

        return $result;
    }
    public function getRestaurantsByCuisine($cuisineType): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare(
            '
            SELECT r.id, r.name, l.address, ci.name as city, string_agg(DISTINCT c.type, \', \') as cuisine, ROUND(CAST(AVG(rev.rating) as numeric), 1) as average_rating, COUNT(rev.id) as number_of_reviews, r.image_path
            FROM restaurants r
            INNER JOIN locations l ON r.location_id = l.id
            INNER JOIN cities ci ON l.city_id = ci.id
            INNER JOIN restaurant_cuisines rc ON r.id = rc.restaurant_id
            INNER JOIN cuisine_types c ON rc.cuisine_type_id = c.id
            LEFT JOIN reviews rev ON r.id = rev.restaurant_id
            WHERE c.type = :cuisineType
            GROUP BY r.id, r.name, l.address, ci.name, r.image_path;
        '
        );

        $stmt->execute([':cuisineType' => $cuisineType]);
        $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($restaurants as $restaurant) {
            $result[] = new Restaurant(
                $restaurant['name'],
                $restaurant['address'],
                $restaurant['average_rating'],
                $restaurant['number_of_reviews'],
                $restaurant['cuisine'],
                $restaurant['image_path'],
                $restaurant['city']
            );
        }

        return $result;
    }
    public function getUserFavoriteRestaurants($userId): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare(
            '
            SELECT r.id, r.name, l.address, ci.name as city, string_agg(DISTINCT c.type, \', \') as cuisine, ROUND(CAST(AVG(rev.rating) as numeric), 1) as average_rating, COUNT(rev.id) as number_of_reviews, r.image_path
            FROM favorite_restaurants uf
            INNER JOIN restaurants r ON uf.restaurant_id = r.id
            INNER JOIN locations l ON r.location_id = l.id
            INNER JOIN cities ci ON l.city_id = ci.id
            INNER JOIN restaurant_cuisines rc ON r.id = rc.restaurant_id
            INNER JOIN cuisine_types c ON rc.cuisine_type_id = c.id
            LEFT JOIN reviews rev ON r.id = rev.restaurant_id
            WHERE uf.user_id = :userId
            GROUP BY r.id, r.name, l.address, ci.name, r.image_path;
            '
        );

        $stmt->execute([':userId' => $userId]);
        $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($restaurants as $restaurant) {
            $result[] = new Restaurant(
                $restaurant['name'],
                $restaurant['address'],
                $restaurant['average_rating'],
                $restaurant['number_of_reviews'],
                $restaurant['cuisine'],
                $restaurant['image_path'],
                $restaurant['city']
            );
        }

        return $result;
    }

    public function getNearbyRestaurants($userLocation): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare(
            '
            SELECT r.id, r.name, l.address, ci.name as city, string_agg(DISTINCT c.type,\',
            \') as cuisine,
            ROUND(CAST(AVG(rev.rating) as numeric), 1) as average_rating,
            COUNT(rev.id) as number_of_reviews, r.image_path
     FROM restaurants r
     INNER JOIN locations l ON r.location_id = l.id
     INNER JOIN cities ci ON l.city_id = ci.id
     INNER JOIN restaurant_cuisines rc ON r.id = rc.restaurant_id
     INNER JOIN cuisine_types c ON rc.cuisine_type_id = c.id
     LEFT JOIN reviews rev ON r.id = rev.restaurant_id
     WHERE ci.name =:city
     GROUP BY r.id, r.name, l.address, ci.name, r.image_path;
            '
        );

        $stmt->execute([
            ':city' => $userLocation
        ]);
        $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($restaurants as $restaurant) {
            $result[] = new Restaurant(
                $restaurant['name'],
                $restaurant['address'],
                $restaurant['average_rating'],
                $restaurant['number_of_reviews'],
                $restaurant['cuisine'],
                $restaurant['image_path'],
                $restaurant['city']
            );
        }

        return $result;
    }

    public function getBestRestaurantsInTown(): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare(
            '
            SELECT r.id, r.name, l.address, ci.name as city, string_agg(DISTINCT c.type, \', \') as cuisine, ROUND(CAST(AVG(rev.rating) as numeric), 1) as average_rating, COUNT(rev.id) as number_of_reviews, r.image_path
            FROM restaurants r
            INNER JOIN locations l ON r.location_id = l.id
            INNER JOIN cities ci ON l.city_id = ci.id
            INNER JOIN restaurant_cuisines rc ON r.id = rc.restaurant_id
            INNER JOIN cuisine_types c ON rc.cuisine_type_id = c.id
            LEFT JOIN reviews rev ON r.id = rev.restaurant_id
            GROUP BY r.id, r.name, l.address, ci.name, r.image_path
            ORDER BY average_rating DESC
            LIMIT 10;
            '
        );

        $stmt->execute();
        $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($restaurants as $restaurant) {
            $result[] = new Restaurant(
                $restaurant['name'],
                $restaurant['address'],
                $restaurant['average_rating'],
                $restaurant['number_of_reviews'],
                $restaurant['cuisine'],
                $restaurant['image_path'],
                $restaurant['city']
            );
        }

        return $result;
    }
}
