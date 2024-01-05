<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GiroDelGusto</title>
    <link rel="stylesheet" href="../../public/css/global.css" />
    <link rel="stylesheet" href="../../public/css/menubar.css" />
    <link rel="stylesheet" href="../../public/css/feed.css" />

    <link rel="apple-touch-icon" sizes="180x180" href="../../public/icons/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../public/icons/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../public/icons/favicons/favicon-16x16.png">
    <link rel="manifest" href="../../public/icons/favicons/site.webmanifest">
    <link rel="mask-icon" href="../../public/icons/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <?php
    $restaurantRepository = new RestaurantRepository();
    $reviewRepository = new ReviewRepository();
    $userRepository = new UserRepository();
    $restaurants = $restaurantRepository->getAllRestaurants();
    $user = $userRepository->getUserByEmail($_SESSION['email']);
    $userId = $user->getId();
    $feed = $reviewRepository->getUserFeed($userId);
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
                <a class=" menuitem" href="mainmenu">
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
                <a class="active menuitem" href="feed">
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
        <div class="feed">
            <?php
            // todo
            foreach ($feed as $item) {
                echo '<div class="review-container">';
                echo '<div class="review-head">';
                echo '<div class="left-elem">';
                echo '<img src="' . htmlspecialchars($item['user_image_path']) . '" alt="Profile Picture" class="profile-picture">';
                echo '<div class="name">' . htmlspecialchars($item['user_username']) . '</div>';
                echo '</div>';
                echo '<div class="right-elem">';
                echo '<div class="time">' . (isset($item['date_added']) ? htmlspecialchars(date('H:i', strtotime($item['date_added']))) : '') . '</div>';
                echo '<div class="date">' . (isset($item['date_added']) ? htmlspecialchars(date('d.m.Y', strtotime($item['date_added']))) : '') . '</div>';
                echo '<a href="deleteReview?review_id=' . htmlspecialchars($item['review_id']) . '&user_id=' . htmlspecialchars($userId) . '">';
                echo '<img src="../../public/data/delete.png" class="delete-icon" />';
                echo '</a>';
                echo '</div>';
                echo '</div>';
                echo '<div class="review-content">';
                echo 'Visited: <span class="visited-place">' . htmlspecialchars($item['restaurant_name']) . '</span><br>';
                echo 'Rate: <span class="restaurant-rating">' . htmlspecialchars($item['rating']) . '</span><br>';
                echo 'Ordered:<span class="ordered-food">' . htmlspecialchars($item['food_ordered']) . '</span><br>';
                echo '<span class="opinion">' . htmlspecialchars($item['comment']) . '</span>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>

    </main>

    <footer>
    </footer>
</body>

</html>