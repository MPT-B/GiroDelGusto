<? include 'head.php'; ?>
<? include 'phpRepository.php'; ?>

<link rel="stylesheet" href="../../public/css/userprofile.css" />
<script src="https://kit.fontawesome.com/b9524b5160.js" crossorigin="anonymous"></script>

</head>


<body>
    <?php include 'menubar.php'; ?>

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
                <?php
                if ($userRole == 'admin') {
                    echo '<a href="manageRestaurants" class="profile-option"><i class="fa-regular fa-square-plus"></i>Manage Restaurants</a>';
                }
                ?>
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