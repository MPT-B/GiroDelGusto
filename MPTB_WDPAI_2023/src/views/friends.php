<?php include 'head.php'; ?>
<? include 'phpRepository.php'; ?>
<link rel="stylesheet" href="../../public/css/friends.css" />
<?php
?>
</head>

<body>
    <?php include 'menubar.php'; ?>
    <div class="friends">
        <div class="friends-list">
            <?php foreach ($friends as $friend) : ?>
                <div class="friend-card">
                    <img class="profile-picture" src="<?= htmlspecialchars($friend->getPicturePath()) ?>" alt="<?= htmlspecialchars($friend->getUsername()) ?>">
                    <div class="info">
                        <p class="name"><?= htmlspecialchars($friend->getUsername()) ?></p>
                        <p><span class="bold">Visited:</span> <?= htmlspecialchars($friend->getVisitedPlaces()) ?></p>
                        <p><span class="bold">Likes:</span> <?= htmlspecialchars($friend->getFavoriteCuisines()) ?></p>
                        <p><?= htmlspecialchars($friend->getBio()) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    </main>

    <footer>
    </footer>
</body>

</html>