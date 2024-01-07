<?php
function defaultControllerRoute($page)
{
    return function () use ($page) {
        (new DefaultController())->renderPage($page);
    };
}

require_once 'Routing.php';
$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('', defaultControllerRoute('mainmenu'));
Routing::get('logout', 'SecurityController');
Routing::post('signup', 'SecurityController');
Routing::post('login', 'SecurityController');
Routing::post('updateProfile', 'SecurityController');
Routing::post('getRestaurantsByCuisine', defaultControllerRoute('getRestaurantsByCuisine'));
Routing::post('getRestaurantByName', defaultControllerRoute('getRestaurantByName'));
Routing::post('getRestaurants', defaultControllerRoute('getRestaurants'));
Routing::post('toggleFavorite', defaultControllerRoute('toggleFavorite'));
Routing::get('mainmenu', defaultControllerRoute('mainmenu'));
Routing::get('restaurantlist', defaultControllerRoute('restaurantlist'));
Routing::get('map', defaultControllerRoute('map'));
Routing::get('feed', defaultControllerRoute('feed'));
Routing::get('friends', defaultControllerRoute('friends'));
Routing::get('userprofile', defaultControllerRoute('userprofile'));
Routing::get('userProfileSettings', defaultControllerRoute('userprofileSettings'));
Routing::get('userReview', defaultControllerRoute('userReview'));
Routing::get('manageRestaurants', defaultControllerRoute('manageRestaurants'));
Routing::post('addRestaurant', 'DefaultController');
Routing::get('isFavorite', 'DefaultController');
Routing::get('deleteReview', 'DefaultController');
Routing::post('addReview', 'DefaultController');
Routing::run($path);
