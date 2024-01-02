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
    $userRepository = new UserRepository();
    $user = $userRepository->getUserByEmail($_SESSION['email']);
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
            <div class="category-switch">
                <span class='active followed'>Followed Users</span>
                <span id='line'>|</span>
                <span class='discover'>Discover</span>
            </div>
            <div class="review-container">

                <div class="review-head">
                    <div class="left-elem">
                        <img src="../../public/data/person.svg" alt="Profile Picture" class="profile-picture">
                        <div class="name">Szafa</div>
                    </div>
                    <div class="right-elem">
                        <div class="time">12:21</div>
                        <div class="date">20.10.2023</div>
                    </div>
                </div>
                <div class="review-content">
                    Visited: <span class="visited-place">CracowBurger</span><br>
                    Rate: <span class="rating">5.0</span><br>
                    Ordered:<span class="ordered-food">BBQ Smash double</span><br>
                    <span class="opinion">Najlepszy smash burger w Krakowie, zdecydowanie do powtórzenia</span>
                </div>
            </div>
        </div>
    </main>

    <footer>
    </footer>
</body>

</html>