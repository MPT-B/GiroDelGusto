<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GiroDelGusto</title>
  <link rel="stylesheet" href="../../public/css/global.css" />
  <link rel="stylesheet" href="../../public/css/menubar.css" />
  <link rel="stylesheet" href="../../public/css/mainmenu.css" />
  <link rel="stylesheet" href="../../public/css/divcard.css" />
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

  ?>
</head>

<body>

  <header>
    <a href="userprofile">
      <?php
      echo '<img src="' . htmlspecialchars($user->getPicturePath()) . '" alt="Profile Picture" id="userprofile">';
      ?>
    </a>
    <img id="logo" src="../../public/data/Logo.png" alt="Logo" />
  </header>
  <div class="menubar">
    <ul>
      <li>
        <a class="active menuitem" href="mainmenu">
          <img src="../../public/icons/menu.svg" alt="menu-icon" />
          <p>Menu</p>
        </a>
      </li>
      <li>
        <a class="menuitem" href="restaurantlist">
          <img src="../../public/icons/cluttery.svg" alt="menu-icon" />
          <p>Restaurant List</p>
        </a>
      </li>
      <li>
        <a class="menuitem" href="feed">
          <img src="../../public/icons/feed.svg" alt="menu-icon" />
          <p>Feed</p>
        </a>
      </li>
      <li>
        <a class="menuitem" href="map">
          <img src="../../public/icons/map.svg" alt="menu-icon" />
          <p>Map</p>
        </a>
      </li>
      <li>
        <a class="menuitem" href="friends">
          <img src="../../public/icons/friends.svg" alt="menu-icon" />
          <p>Friends</p>
        </a>
      </li>
    </ul>
  </div>
  <main>
    <section id="search-area">
      <input class="search__input" list="restaurant-names" name="restaurant-name" placeholder="Search" />
      <datalist id="restaurant-names">
        <?php foreach ($restaurants as $restaurant) : ?>
          <option value="<?= $restaurant->getName() ?>">
          <?php endforeach; ?>
      </datalist>
    </section>
    <section id="search-results"></section>
    <?php
    function generateRestaurantCard($restaurant, $userId, $restaurantRepository)
    {
      $isFavorite = $restaurantRepository->isFavorite($restaurant->getId(), $userId);
      $favoriteIcon = $isFavorite ? 'myfav.svg' : 'fav.svg';
      $cuisines = explode(', ', $restaurant->getCuisineTypes());
    ?>
      <div class="card">
        <div class="card-header">
          <span class="rating">
            <?= $restaurant->getAverageRating() ?? 0 ?>
            <span class="star">&#9733;</span>
            <span class="rating-count">(<?= $restaurant->getNumberOfReviews() ?>+)</span>
          </span>
          <a href="toggleFavorite?restaurant_id=<?php echo $restaurant->getId(); ?>&user_id=<?php echo $userId; ?>">
            <img src="../../public/data/<?= $favoriteIcon ?>" class="favorite-icon" />
          </a>
        </div>
        <img src="<?= $restaurant->getImageUrl() ?>" alt="Restaurant Image" class="card-image" />
        <div class="card-body">
          <div class="restaurant-title">
            <?= $restaurant->getName() ?><span class="verified-icon">&#10004;</span>
          </div>
          <div class="restaurant-location"><?= $restaurant->getAddress() . ', ' . $restaurant->getCity() ?></div>
          <div class="tags">
            <?php foreach ($cuisines as $cuisine) : ?>
              <span class="tag"><?= $cuisine ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    <?php
    }
    ?>

    <section id="restaurant-content">
      <section id="nearby-restaurants">
        <h2>Nearby Restaurants</h2>
        <div class="cardlist">
          <?php foreach ($nearbyRestaurants as $restaurant) : ?>
            <?php generateRestaurantCard($restaurant, $userId, $restaurantRepository); ?>
          <?php endforeach; ?>
        </div>
      </section>
      <section id="best-in-town">
        <h2>Best in Town</h2>
        <div class="cardlist">
          <?php foreach ($bestInTown as $restaurant) : ?>
            <?php generateRestaurantCard($restaurant, $userId, $restaurantRepository); ?>
          <?php endforeach; ?>
        </div>
      </section>
      <section id="favorite">
        <h2>Yours Favorite</h2>
        <div class="cardlist">
          <?php foreach ($userFavorites as $restaurant) : ?>
            <?php generateRestaurantCard($restaurant, $userId, $restaurantRepository); ?>
          <?php endforeach; ?>
        </div>
      </section>
    </section>
  </main>
</body>
<script>
</script>

</html>