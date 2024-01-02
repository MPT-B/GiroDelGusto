<?php
require_once 'Routing.php';
$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('', 'DefaultController');
Routing::post('signup', 'SecurityController');
Routing::post('login', 'SecurityController');
Routing::get('logout', 'SecurityController');
Routing::get('mainmenu', 'DefaultController');
Routing::get('restaurantlist', 'DefaultController');
Routing::get('map', 'DefaultController');
Routing::get('feed', 'DefaultController');
Routing::get('friends', 'DefaultController');
Routing::get('userprofile', 'DefaultController');
Routing::get('toggle_favorite', 'DefaultController');
Routing::post('getRestaurantsByCuisine', 'DefaultController');
Routing::run($path);
