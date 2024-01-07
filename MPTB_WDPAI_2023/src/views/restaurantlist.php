<?php include 'head.php'; ?>
<?php include 'phpRepository.php'; ?>

<link rel="stylesheet" href="../../public/css/restaurantlist.css" />

</head>

<body>
  <?php include 'menubar.php'; ?>
  <?php include 'search.php'; ?>

  <main>

    <div class="foodfilter">
      <?php foreach ($cuisineTypes as $cuisineType) : ?>
        <div class=" foodfilter-item">
          <img width="94" height="94" src="<?php echo $cuisineType['icon']; ?>" alt="<?php echo $cuisineType['type']; ?>" />
          <span><?php echo $cuisineType['type']; ?></span>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="restaurantlist" id='restaurant-list'>
      <div class="cardlist">
      </div>
    </div>
  </main>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      handleFoodFilterClick(<?php echo json_encode($userId); ?>);
      handleSearchInput(<?php echo json_encode($userId); ?>);
    });
  </script>
  <footer>

  </footer>
</body>

</html>