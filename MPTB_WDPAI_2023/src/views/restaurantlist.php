<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GiroDelGusto</title>
  <link rel="stylesheet" href="../../public/css/global.css" />
  <link rel="stylesheet" href="../../public/css/menubar.css" />
  <link rel="stylesheet" href="../../public/css/mainmenu.css" />
  <link rel="stylesheet" href="../../public/css/restaurantlist.css" />

  <link rel="apple-touch-icon" sizes="180x180" href="../../public/icons/favicons/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../../public/icons/favicons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../../public/icons/favicons/favicon-16x16.png">
  <link rel="manifest" href="../../public/icons/favicons/site.webmanifest">
  <link rel="mask-icon" href="../../public/icons/favicons/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">


  <?php
  session_start();
  $restaurantRepo = new RestaurantRepository();
  $userRepository = new UserRepository();

  $restaurants = $restaurantRepo->getRestaurant();
  $user = $userRepository->getUserByEmail($_SESSION['email']);
  $userId = $user->getId();
  ?>

</head>

<body>
  <header>
    <a href="userprofile"><img id="userprofile" src="../../public/data/Ellipse 1.png" alt="userprofile" /></a>
    <img id="logo" src="../../public/data/Logo.png" alt="Logo" />
  </header>
  <div class="menubar">
    <ul>
      <li>
        <a class="menuitem" href="mainmenu">
          <img src="../../public/icons/menu.svg" alt="menu-icon" />
          <p>Menu</p>
        </a>
      </li>
      <li>
        <a class="active menuitem" href="restaurantlist">
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
  <section id="search-area">
    <input class="search__input" type="text" placeholder="Search" />
  </section>
  <main>
    <div class="foodfilter">
      <div class="foodfilter-item active">
        <img width="94" height="94" src="https://img.icons8.com/3d-fluency/94/hamburger.png" alt="hamburger" />
        <span>Burger</span>
      </div>
      <div class="foodfilter-item">
        <img width="94" height="94" src="https://img.icons8.com/3d-fluency/94/doughnut.png" alt="doughnut" />
        <span>Donut</span>
      </div>
      <div class="foodfilter-item">
        <img width="94" height="94" src="https://img.icons8.com/3d-fluency/94/salami-pizza.png" alt="salami-pizza" />
        <span>Pizza</span>
      </div>
      <div class="foodfilter-item">
        <img width="94" height="94" src="https://img.icons8.com/3d-fluency/94/pancake.png" alt="pancake" />
        <span>Pancake</span>
      </div>
      <div class="foodfilter-item">
        <img width="94" height="94" src="https://img.icons8.com/3d-fluency/94/noodles.png" alt="noodles" />
        <span>Asian</span>
      </div>
    </div>




    <div class="restaurantlist">
      <div class="cardlist">
        <!-- here start cars -->
        <?php foreach ($restaurants as $restaurant) : ?>
          <div class="card">
            <div class="card-header">
              <span class="rating">
                <?= $restaurant->getAverageRating() ?? 0 ?>
                <span class="star">&#9733;</span>
                <span class="rating-count">(<?= $restaurant->getNumberOfReviews() ?>+)</span>
              </span>
              <a href="toggle_favorite?restaurant_id=<?php echo $restaurantRepo->getRestaurantId($restaurant->getName()); ?>&user_id=<?php echo $userId; ?>">
                <img src="../../public/data/<?php $isFavorite = $restaurantRepo->isFavorite($restaurantRepo->getRestaurantId($restaurant->getName()), $userId);
                                            $favoriteIcon = $isFavorite ? 'myfav.svg' : 'fav.svg';
                                            echo $favoriteIcon; ?>" class="favorite-icon" />
              </a>
            </div>
            <img src="<?= $restaurant->getImageUrl() ?>" alt="Restaurant Image" class="card-image" />
            <div class="card-body">
              <div class="restaurant-title">
                <?= $restaurant->getName() ?><span class="verified-icon">&#10004;</span>
              </div>
              <div class="restaurant-location"><?= $restaurant->getAddress() . ', ' . $restaurant->getCity() ?></div>
              <div class="tags">
                <?php
                $cuisines = explode(', ', $restaurant->getCuisineTypes());
                foreach ($cuisines as $cuisine) :
                ?>
                  <span class="tag"><?= $cuisine ?></span>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>


      </div>
    </div>
  </main>

  <footer>
    <!-- Footer content -->
  </footer>
</body>

</html>
<script>
  document.querySelector(".menu-icon").addEventListener("click", function() {
    document.querySelector(".menubar ul").classList.toggle("show");
  });
</script>