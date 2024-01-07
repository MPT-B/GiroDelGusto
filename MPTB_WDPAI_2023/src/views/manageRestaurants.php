<? include 'head.php'; ?>
<? include 'phpRepository.php'; ?>

<link rel="stylesheet" href="../../public/css/forms.css" />


<body>
    <?php

    ?>
    <div class="login-container">
        <div class="logo">
            <img src="../../public/data/Logo.png" alt="Giro Del Gusto Logo" />
        </div>
        <h1>Add New Restaurant</h1>
        <?php
        if (isset($_SESSION['message'])) {
            echo "<p>" . $_SESSION['message'] . "</p>";
            unset($_SESSION['message']);
        }
        ?>
        <form action="addRestaurant" method="post" enctype="multipart/form-data">
            <label for="name">Restaurant Name:</label>
            <input type="text" id="name" name="name" required />

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required />

            <label for="city">City:</label>
            <select id="city" name="city">
                <?php foreach ($cities as $city) : ?>
                    <option value="<?= $city['id'] ?>"><?= $city['name'] ?></option>
                <?php endforeach; ?>
            </select>

            <label for="cuisine">Cuisine:</label>
            <select id="cuisine" name="cuisine">
                <?php foreach ($cuisineTypes as $cuisine) : ?>
                    <option value="<?= $cuisine['id'] ?>"><?= $cuisine['type'] ?></option>
                <?php endforeach; ?>
            </select>

            <label for="photo" id='file-upload'>Restaurant Photo:
                <input type="file" id="photo" name="photo" />
            </label>
            <button type="submit">ADD RESTAURANT</button>
            <button type="button" onclick="window.location.href='mainmenu';">GO BACK</button>

        </form>
    </div>
</body>

</html>