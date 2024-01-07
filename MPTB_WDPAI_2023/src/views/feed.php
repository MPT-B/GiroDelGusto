<? include 'head.php'; ?>
<link rel="stylesheet" href="../../public/css/feed.css" />
<? include 'phpRepository.php'; ?>

</head>

<body>
    <?php include 'menubar.php'; ?>

    <main>
        <div class="feed">
            <div class="category-switch">
                <a href="?category=followed" class="category <?php echo (isset($_GET['category']) && $_GET['category'] === 'followed') ? 'active' : '' ?>">Followed Users</a>
                <span id='line'>|</span>
                <a href="?category=discover" class="category <?php echo (isset($_GET['category']) && $_GET['category'] === 'discover') ? 'active' : '' ?>">Discover</a>
            </div>
            <?php
            if (isset($_GET['category']) && $_GET['category'] === 'followed') {
                $feed = $reviewRepository->getFriendsFeed($userId);
            } else if (isset($_GET['category']) && $_GET['category'] === 'discover') {
                $feed = $reviewRepository->getFeed();
            } else {
                $feed = $reviewRepository->getFriendsFeed($userId);
            }
            foreach ($feed as $item) {
                $deleteIcon = '';
                if ($user->getRole() === 'admin') {
                    $deleteIcon = <<<EOT
            <a href="deleteReview?review_id={$item['review_id']}&user_id={$userId}">
                <img src="../../public/data/delete.png" class="delete-icon" />
            </a>
EOT;
                }
                $time = isset($item['date_added']) ? date('H:i', strtotime($item['date_added'])) : '';
                $date = isset($item['date_added']) ? date('d.m.Y', strtotime($item['date_added'])) : '';

                echo <<<EOT
        <div class="review-container">
            <div class="review-head">
                <div class="left-elem">
                    <img src="{$item['user_image_path']}" alt="Profile Picture" class="profile-picture">
                    <div class="name">{$item['user_username']}</div>
                </div>
                <div class="right-elem">
                    <div class="time">{$time}</div>
                    <div class="date">{$date}</div>
                    {$deleteIcon}
                </div>
            </div>
            <div class="review-content">
                Visited: <span class="visited-place">{$item['restaurant_name']}</span><br>
                Rate: <span class="restaurant-rating">{$item['rating']}</span><br>
                Ordered:<span class="ordered-food">{$item['food_ordered']}</span><br>
                <span class="opinion">{$item['comment']}</span>
            </div>
        </div>
    EOT;
            }
            ?>
        </div>

        <div class="restaurant-review" id="reviewForm">
            <div class="collapsed-content">Have you eaten anything delicious</div>
            <h2>Enter your restaurant review</h2>
            <form action="addReview" method="post">
                <label for="restaurant-name">Restaurant Name:</label>
                <input list="restaurant-names" id="restaurant-name" name="restaurant-name" required />

                <datalist id="restaurant-names">
                    <?php foreach ($restaurants as $restaurant) : ?>
                        <option value="<?= $restaurant->getName() ?>">
                        <?php endforeach; ?>
                </datalist>
                <label>Rating:</label>
                <div class="rating">
                    <input type="radio" id="star1" name="rating" value="1" />
                    <label class='stars-label' for="star1"><span>&#9733;</span></label>
                    <input type="radio" id="star2" name="rating" value="2" />
                    <label class='stars-label' for="star2"><span>&#9733;</span></label>
                    <input type="radio" id="star3" name="rating" value="3" />
                    <label class='stars-label' for="star3"><span>&#9733;</span></label>
                    <input type="radio" id="star4" name="rating" value="4" />
                    <label class='stars-label' for="star4"><span>&#9733;</span></label>
                    <input type="radio" id="star5" name="rating" value="5" />
                    <label class='stars-label' for="star5"><span>&#9733;</span></label>
                </div>

                <label for="opinion">Your Opinion:</label>
                <textarea id="opinion" name="opinion" rows="4" required></textarea>

                <label for="food">What did you order:</label>
                <input type="text" id="food" name="food" required />

                <button type="submit">Add Review</button>
            </form>
        </div>
    </main>

    <footer>
    </footer>
</body>
<script>
    document.addEventListener("DOMContentLoaded", (event) => {
        const reviewForm = document.getElementById("reviewForm");

        function toggleReviewForm() {
            reviewForm.classList.toggle("expanded");
        }

        reviewForm.addEventListener("click", function() {
            toggleReviewForm();
        });

        reviewForm
            .querySelector("form")
            .addEventListener("click", function(event) {
                event.stopPropagation();
            });

        document.addEventListener("click", function(event) {
            if (
                reviewForm.classList.contains("expanded") &&
                !reviewForm.contains(event.target)
            ) {
                toggleReviewForm();
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        handleSearchInput(<?php echo json_encode($userId); ?>);
    });
</script>

</html>