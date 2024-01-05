<?php
class Query
{
    public function getRestaurantsQuery(): string
    {
        return '
            SELECT r.id, r.name, l.address, ci.name as city, string_agg(DISTINCT c.type, \', \') as cuisine, ROUND(CAST(AVG(rev.rating) as numeric), 1) as average_rating,(SELECT COUNT(*) FROM reviews WHERE restaurant_id = r.id) as number_of_reviews, r.image_path
            FROM restaurants r
            INNER JOIN locations l ON r.location_id = l.id
            INNER JOIN cities ci ON l.city_id = ci.id
            INNER JOIN restaurant_cuisines rc ON r.id = rc.restaurant_id
            INNER JOIN cuisine_types c ON rc.cuisine_type_id = c.id
            LEFT JOIN reviews rev ON r.id = rev.restaurant_id
            GROUP BY r.id, r.name, l.address, ci.name, r.image_path;
        ';
    }
    public function getRestaurantsByCuisine($cuisineType): string
    {
        return "
            SELECT r.id, r.name, l.address, ci.name as city, string_agg(DISTINCT c.type, ', ') as cuisine, ROUND(CAST(AVG(rev.rating) as numeric), 1) as average_rating,(SELECT COUNT(*) FROM reviews WHERE restaurant_id = r.id) as number_of_reviews, r.image_path
            FROM restaurants r
            INNER JOIN locations l ON r.location_id = l.id
            INNER JOIN cities ci ON l.city_id = ci.id
            INNER JOIN restaurant_cuisines rc ON r.id = rc.restaurant_id
            INNER JOIN cuisine_types c ON rc.cuisine_type_id = c.id
            LEFT JOIN reviews rev ON r.id = rev.restaurant_id
            WHERE c.type = '$cuisineType'
            GROUP BY r.id, r.name, l.address, ci.name, r.image_path;
        ";
    }

    public function getUserFavoriteRestaurants($userId): string
    {
        return "
        SELECT r.id, r.name, l.address, ci.name as city, string_agg(DISTINCT c.type, ', ') as cuisine, ROUND(CAST(AVG(rev.rating) as numeric), 1) as average_rating,(SELECT COUNT(*) FROM reviews WHERE restaurant_id = r.id) as number_of_reviews, r.image_path
        FROM favorite_restaurants uf
        INNER JOIN restaurants r ON uf.restaurant_id = r.id
        INNER JOIN locations l ON r.location_id = l.id
        INNER JOIN cities ci ON l.city_id = ci.id
        INNER JOIN restaurant_cuisines rc ON r.id = rc.restaurant_id
        INNER JOIN cuisine_types c ON rc.cuisine_type_id = c.id
        LEFT JOIN reviews rev ON r.id = rev.restaurant_id
        WHERE uf.user_id = '$userId'
        GROUP BY r.id, r.name, l.address, ci.name, r.image_path;
        ";
    }

    public function getNearbyRestaurants($city): string
    {
        return "
        SELECT r.id, r.name, l.address, ci.name as city, string_agg(DISTINCT c.type, ', ') as cuisine,
        ROUND(CAST(AVG(rev.rating) as numeric), 1) as average_rating,
        (SELECT COUNT(*) FROM reviews WHERE restaurant_id = r.id) as number_of_reviews, r.image_path
        FROM restaurants r
        INNER JOIN locations l ON r.location_id = l.id
        INNER JOIN cities ci ON l.city_id = ci.id
        INNER JOIN restaurant_cuisines rc ON r.id = rc.restaurant_id
        INNER JOIN cuisine_types c ON rc.cuisine_type_id = c.id
        LEFT JOIN reviews rev ON r.id = rev.restaurant_id
        WHERE ci.name ='$city'
        GROUP BY r.id, r.name, l.address, ci.name, r.image_path;
        ";
    }

    public function getBestRestaurantsInTown($town): string
    {
        return "
        SELECT r.id, r.name, l.address, ci.name as city, string_agg(DISTINCT c.type, ', ') as cuisine,
        ROUND(CAST(AVG(rev.rating) as numeric), 1) as average_rating,
        (SELECT COUNT(*) FROM reviews WHERE restaurant_id = r.id) as number_of_reviews,
        r.image_path
        FROM restaurants r
        INNER JOIN locations l ON r.location_id = l.id
        INNER JOIN cities ci ON l.city_id = ci.id
        INNER JOIN restaurant_cuisines rc ON r.id = rc.restaurant_id
        INNER JOIN cuisine_types c ON rc.cuisine_type_id = c.id
        LEFT JOIN reviews rev ON r.id = rev.restaurant_id
        WHERE ci.name = '$town'
        GROUP BY r.id, r.name, l.address, ci.name, r.image_path
        ORDER BY average_rating DESC
        LIMIT 10;";
    }
    public function isFavorite($restaurantId, $userId,): string
    {
        return "
            SELECT user_id, restaurant_id
            FROM favorite_restaurants
            WHERE user_id = :userId AND restaurant_id = :restaurantId
    ";
    }
    public function getRestaurantIdByNameQuery(): string
    {
        return 'SELECT id FROM public.restaurants WHERE name = :name';
    }
    // USERS
    public function getUserQuery(): string
    {
        return '
            SELECT users.*, profile.picture_path
            FROM users
            LEFT JOIN profile ON users.id = profile.user_id;
        ';
    }

    public function getUserByEmailQuery(): string
    {
        return '
            SELECT users.*, profile.picture_path
            FROM users
            LEFT JOIN profile ON users.id = profile.user_id
            WHERE email = :email
        ';
    }

    public function getUserByIdQuery(): string
    {
        return '
            SELECT users.*, profile.picture_path
            FROM users
            LEFT JOIN profile ON users.id = profile.user_id
            WHERE id = :id
        ';
    }
    public function addUserQuery(): string
    {
        return 'INSERT INTO public.users(email, username, password, role) VALUES (?, ?, ?, ?)';
    }

    public function userExistsQuery(): string
    {
        return 'SELECT * FROM public.users WHERE email = ?';
    }
    public function getFriendsByUserIdQuery(): string
    {
        return '
        SELECT 
                     u.*, 
                     p.bio, 
                     p.visited_places, 
                     p.picture_path,
                     STRING_AGG(DISTINCT ct.type, \',
                             \') AS favorite_cuisines
                 FROM 
                     public.users u
                 JOIN 
                     public.friendships f ON(f.member1_id = u.id OR f.member2_id = u.id) AND u.id <> :userId
                 JOIN 
                     public.profile p ON p.user_id = u.id
                 LEFT JOIN 
                     public.user_cuisine_preferences c ON c.user_id = u.id
                 LEFT JOIN 
                     public.cuisine_types ct ON ct.id = c.cuisine_id
                 WHERE
                     f.member1_id = :userId OR f.member2_id = :userId
                 GROUP BY 
                     u.id, p.bio, p.visited_places, p.picture_path;';
    }
    public function getUserProfile(): string
    {
        return '
    SELECT 
                 u.*, 
                 p.bio, 
                 p.visited_places, 
                 p.picture_path,
                 STRING_AGG(DISTINCT ct.type, \',\') AS favorite_cuisines
             FROM 
                 public.users u
             JOIN 
                 public.profile p ON p.user_id = u.id
             LEFT JOIN 
                 public.user_cuisine_preferences c ON c.user_id = u.id
             LEFT JOIN 
                 public.cuisine_types ct ON ct.id = c.cuisine_id
             WHERE
                 u.id = :userId
             GROUP BY 
                 u.id, p.bio, p.visited_places, p.picture_path;';
    }
    public function getFriendsFeedQuery(): string
    {
        return '
        SELECT DISTINCT
        r.id as review_id,
         u.username AS user_username,
         p.picture_path AS user_image_path,
         r.rating,
         res.name AS restaurant_name,
         r.comment,
         r.food_ordered,
         r.date_added
     FROM
         public.users u
     JOIN
         public.friendships f ON (f.member1_id = u.id OR f.member2_id = u.id)
     JOIN
         public.reviews r ON u.id = r.user_id
     JOIN
         public.restaurants res ON r.restaurant_id = res.id
     JOIN
         public.profile p ON u.id = p.user_id
     WHERE
         (f.member1_id = :userId OR f.member2_id = :userId)
         AND u.id <> :userId
     ORDER BY r.date_added DESC;
                     ';
    }
    public function getUserFeedQuery(): string
    {
        return '
        SELECT DISTINCT
            r.id as review_id,
            u.username AS user_username,
            p.picture_path AS user_image_path,
            r.rating,
            res.name AS restaurant_name,
            r.comment,
            r.food_ordered,
            r.date_added
        FROM
            public.users u
        JOIN
            public.reviews r ON u.id = r.user_id
        JOIN
            public.restaurants res ON r.restaurant_id = res.id
        JOIN
            public.profile p ON u.id = p.user_id
        WHERE
            u.id = :userId
        ORDER BY
            r.date_added DESC;
    ';
    }
    public function addReviewQuery(): string
    {
        return 'INSERT INTO public.reviews(user_id, restaurant_id, rating, comment, date_added, food_ordered) VALUES (?, ?, ?, ?, ?, ?)';
    }
}
