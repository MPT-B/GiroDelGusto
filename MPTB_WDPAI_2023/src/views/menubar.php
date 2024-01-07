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