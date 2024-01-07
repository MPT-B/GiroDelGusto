<?php
require_once 'controllers/DefaultController.php';
require_once 'controllers/SecurityController.php';
require_once 'controllers/ErrorController.php';

class Routing
{
  public static $routes;

  public static function get($url, $view)
  {
    self::$routes[$url] = $view;
  }

  public static function post($url, $view)
  {
    self::$routes[$url] = $view;
  }

  public static function run($url)
  {
    $action = explode("/", $url)[0];
    $errorController = new ErrorController();

    if (!array_key_exists($action, self::$routes)) {
      $errorController->handle('wrong_url');
    }

    $defaultControllerActions = [
      'isFavorite',
      'getRestaurantsByCuisine',
      'toggleFavorite',
      'getRestaurantByName',
      'getRestaurants'
    ];

    if (in_array($action, $defaultControllerActions)) {
      self::handleDefaultControllerAction($action);
    } else {
      $route = self::$routes[$action];
      if ($route instanceof Closure) {
        $route();
      } else {
        $object = new $route;
        $object->$action();
      }
    }
  }

  private static function handleDefaultControllerAction($action)
  {
    $controller = new DefaultController();

    if ($action === 'isFavorite') {
      $restaurantId = $_GET['restaurant_id'];
      $userId = $_GET['user_id'];
      $controller->isFavorite($restaurantId, $userId);
    } else {
      $controller->$action();
    }
  }
}
