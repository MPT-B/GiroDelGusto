<? include 'head.php'; ?>
<? include 'phpRepository.php'; ?>

<link rel="stylesheet" href="../../public/css/feed.css" />

</head>

<body>
    <?php include 'menubar.php'; ?>
    <main>
        <div class="feed">
            <?php foreach ($feed as $item) : ?>
                <div class="review-container">
                    <div class="review-head">
                        <div class="left-elem">
                            <img src="<?= htmlspecialchars($item['user_image_path']) ?>" alt="Profile Picture" class="profile-picture">
                            <div class="name"><?= htmlspecialchars($item['user_username']) ?></div>
                        </div>
                        <div class="right-elem">
                            <div class="time"><?= isset($item['date_added']) ? htmlspecialchars(date('H:i', strtotime($item['date_added']))) : '' ?></div>
                            <div class="date"><?= isset($item['date_added']) ? htmlspecialchars(date('d.m.Y', strtotime($item['date_added']))) : '' ?></div>
                            <a href="deleteReview?review_id=<?= htmlspecialchars($item['review_id']) ?>&user_id=<?= htmlspecialchars($userId) ?>">
                                <img src="../../public/data/delete.png" class="delete-icon" />
                            </a>
                        </div>
                    </div>
                    <div class="review-content">
                        Visited: <span class="visited-place"><?= htmlspecialchars($item['restaurant_name']) ?></span><br>
                        Rate: <span class="restaurant-rating"><?= htmlspecialchars($item['rating']) ?></span><br>
                        Ordered:<span class="ordered-food"><?= htmlspecialchars($item['food_ordered']) ?></span><br>
                        <span class="opinion"><?= htmlspecialchars($item['comment']) ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
    </footer>
</body>

</html>