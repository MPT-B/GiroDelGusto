<? include 'head.php'; ?>
<? include 'phpRepository.php'; ?>

<?php
$nearbyRestaurants = $restaurantRepository->getNearbyRestaurants($town);
$bestInTown = $restaurantRepository->getBestRestaurantsInTown($town);
$userFavorites = $restaurantRepository->getUserFavoriteRestaurants($userId);
?>

<body>
  <?php include 'menubar.php'; ?>
  <?php include 'search.php'; ?>
  <main>
    <h2>Nearby Restaurants</h2>
    <div id="nearby-restaurants" class="card-list"></div>
    <h2>Best in Town</h2>
    <div id="best-in-town" class="card-list"></div>
    <h2>Yours Favorite</h2>
    <div id="favorite-list" class="card-list"></div>
  </main>
</body>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    fetchRestaurants(<?php echo json_encode($userId); ?>, 'Krakow');
    handleSearchInput(<?php echo json_encode($userId); ?>);
  });
</script>

</html>