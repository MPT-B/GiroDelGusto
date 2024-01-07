<?php include 'head.php'; ?>
<?php include 'phpRepository.php'; ?>

<link rel="stylesheet" href="../../public/css/map.css" />

</head>

<body>
    <?php include 'menubar.php'; ?>

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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            handleFoodFilterClick(<?php echo json_encode($userId); ?>);
            handleSearchInput(<?php echo json_encode($userId); ?>);
        });
    </script>
</body>

</html>