<?php
// search.php

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // Tutaj wykonaj logikę wyszukiwania w bazie danych na podstawie frazy $query
    $results = $restaurantRepository->getRestaurantIdByName($query);
    // Zwróć wyniki jako JSON
    echo json_encode($results);
} else {
    // Zapytanie nie zawiera frazy wyszukiwania
    echo json_encode([]);
}
