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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <?php
  $restaurantRepo = new RestaurantRepository();
  $userRepository = new UserRepository();

  $cuisineTypes = $restaurantRepo->getCuisineTypes();
  $restaurants = $restaurantRepo->getAllRestaurants();
  $user = $userRepository->getUserByEmail($_SESSION['email']);
  $userId = $user->getId();
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
    <input class="search__input" list="restaurant-names" name="restaurant-name" placeholder="Search" />
    <datalist id="restaurant-names">
      <?php foreach ($restaurants as $restaurant) : ?>
        <option value="<?= $restaurant->getName() ?>">
        <?php endforeach; ?>
    </datalist>
  </section>
  <main>


    <div class="foodfilter">
      <?php foreach ($cuisineTypes as $cuisineType) : ?>
        <div class="foodfilter-item">
          <img width="94" height="94" src="<?php echo $cuisineType['icon']; ?>" alt="<?php echo $cuisineType['type']; ?>" />
          <span><?php echo $cuisineType['type']; ?></span>
        </div>
      <?php endforeach; ?>
    </div>
    <script>
      //  TODO move to separate js files
      var userId = <?php echo json_encode($userId); ?>;
      $('.foodfilter-item').on('click', function() {
        var cuisineType = $(this).find('span').text();
        $.ajax({
          url: '/getRestaurantsByCuisine',
          type: 'POST',
          data: {
            'cuisine_types': cuisineType
          },
          success: function(restaurants) {
            console.log('Restaurants: ', restaurants);
            $('.cardlist').empty();
            if (!restaurants || !restaurants.length) {
              $('.cardlist').append(
                '<div class="no-restaurant-found">No restaurants found for the selected cuisine type.</div>');
              console.log('No restaurants found for the selected cuisine type.');
              return;
            }
            $.each(restaurants, function(i, restaurant) {
              if (restaurant.cuisine) {
                var cuisines = restaurant.cuisine.split(', ');
                var cuisineTags = '';
                $.each(cuisines, function(i, cuisine) {
                  cuisineTags += '<span class="tag">' + cuisine + '</span>';
                });

                $('.cardlist').append(
                  '<div class="card">' +
                  '<div class="card-header">' +
                  '<span class="rating">' +
                  restaurant.average_rating +
                  '<span class="star">&#9733;</span>' +
                  '<span class="rating-count">(' + restaurant.number_of_reviews + '+)</span>' +
                  '</span>' +
                  '<a href="toggleFavorite?restaurant_id=' + restaurant.id + '&user_id=' + userId + '">' +
                  '<img src="../../public/data/' + (restaurant.isFavorite ? 'myfav.svg' : 'fav.svg') + '" class="favorite-icon" />' +
                  '</a>' +
                  '</div>' +
                  '<img src="' + restaurant.image_path + '" alt="Restaurant Image" class="card-image" />' +
                  '<div class="card-body">' +
                  '<div class="restaurant-title">' +
                  restaurant.name + '<span class="verified-icon">&#10004;</span>' +
                  '</div>' +
                  '<div class="restaurant-location">' + restaurant.address + ', ' + restaurant.city + '</div>' +
                  '<div class="tags">' + cuisineTags + '</div>' +
                  '</div>' +
                  '</div>'
                );
              } else {
                console.log('Restaurant object does not have a cuisineTypes property:', restaurant);
              }
            });
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log('AJAX request failed: ', textStatus, errorThrown);
          }
        });

        $('.foodfilter-item').removeClass('active');
        $(this).addClass('active');
      });
    </script>
    <div class="restaurantlist" id='restaurant-list'>
      <div class="cardlist">
        <!-- here start cards -->
      </div>
    </div>
  </main>

  <footer>

  </footer>
</body>

</html>
<script>
  document.querySelector(".menu-icon").addEventListener("click", function() {
    document.querySelector(".menubar ul").classList.toggle("show");
  });
</script>