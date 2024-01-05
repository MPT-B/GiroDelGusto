<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GiroDelGusto</title>
    <link rel="stylesheet" href="../../public/css/global.css" />
    <link rel="stylesheet" href="../../public/css/menubar.css" />
    <link rel="stylesheet" href="../../public/css/map.css" />

    <link rel="apple-touch-icon" sizes="180x180" href="../../public/icons/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../public/icons/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../public/icons/favicons/favicon-16x16.png">
    <link rel="manifest" href="../../public/icons/favicons/site.webmanifest">
    <link rel="mask-icon" href="../../public/icons/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <?php
    $userRepository = new UserRepository();
    $restaurantRepo = new RestaurantRepository();
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
                <a class="active menuitem" href="map">
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
        <div class="foodfilter">
            <?php foreach ($cuisineTypes as $cuisineType) : ?>
                <div class="foodfilter-item">
                    <img width="94" height="94" src="<?php echo $cuisineType['icon']; ?>" alt="<?php echo $cuisineType['type']; ?>" />
                    <span><?php echo $cuisineType['type']; ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- I need to add API for maps -->
        <div id="map-container"><img id='map' src="../../public/data/MAPS_MOCKUP.png" alt="MAPS_MOCKUP"></div>
        <!-- <div id="map"></div>
        <script src="script.js"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap">
        </script> -->
    </main>

    <footer>
    </footer>
</body>

</html>