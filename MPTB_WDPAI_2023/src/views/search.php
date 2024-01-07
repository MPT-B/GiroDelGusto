<section id="search-area">
    <input class="search__input" list="restaurant-names" name="restaurant-name" placeholder="Search" />
    <datalist id="restaurant-names">
        <?php foreach ($restaurants as $restaurant) : ?>
            <option value="<?= $restaurant->getName() ?>">
            <?php endforeach; ?>
    </datalist>
</section>
<section id="search-results"></section>