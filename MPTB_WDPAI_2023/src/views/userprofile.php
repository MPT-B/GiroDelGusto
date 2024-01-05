<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GiroDelGusto</title>
    <link rel="stylesheet" href="../../public/css/global.css" />
    <link rel="stylesheet" href="../../public/css/userprofile.css" />
    <link rel="stylesheet" href="../../public/css/menubar.css" />

    <script src="https://kit.fontawesome.com/b9524b5160.js" crossorigin="anonymous"></script>
    <?php
    if (isset($_SESSION['email'])) {
        $userRepository = new UserRepository();
        $user = $userRepository->getUserByEmail($_SESSION['email']);
    } else {
        header('Location: login');
        exit();
    }
    ?>
</head>


<body>
    <header>
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

    <body>
        <div class="profile-menu">
            <?php
            echo '<div class="profile-header">';
            echo '<img src="' . htmlspecialchars($user->getPicturePath()) . '" alt="Profile Picture" class="profile-picture">';
            echo '<h1 id="Name">' . htmlspecialchars($user->getUsername()) . '</h1>';
            echo '<p id="email">' . htmlspecialchars($user->getEmail()) . '</p>';
            echo '</div>';
            ?>
            <div class="profile-options">
                <a href="userProfileSettings" class="profile-option"><i class="fa-solid fa-user"></i>My Profile</a>
                <a href="userReview" class="profile-option"><i class="fa-solid fa-magnifying-glass-location"></i>My Reviews</a>
                <a href="#" class="profile-option"><i class="fa-solid fa-gear"></i>Settings</a>
                <a href="#" class="profile-option"><i class="fa-solid fa-circle-question"></i>Help & FAQ</a>
            </div>
            <div class="logout">
                <a href="logout" class="logout-button"><i class="logout fa-solid fa-right-from-bracket"></i><span>Log out</span></a>
            </div>
        </div>
    </body>

    <footer>
    </footer>
</body>

</html>