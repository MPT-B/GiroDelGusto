function handleFoodFilterClick(userId) {
  const foodFilterItems = document.querySelectorAll(".foodfilter-item");

  foodFilterItems.forEach(function (foodFilterItem) {
    foodFilterItem.addEventListener("click", function () {
      const cuisineType = this.querySelector("span").textContent;

      fetch("/getRestaurantsByCuisine", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          cuisine_types: cuisineType,
        }),
      })
        .then((response) => response.json())
        .then((restaurants) => {
          const cardList = document.querySelector(".cardlist");
          cardList.innerHTML = "";

          if (!restaurants || !restaurants.length) {
            cardList.innerHTML =
              '<div class="no-restaurant-found">No restaurants found for the selected cuisine type.</div>';
            console.log("No restaurants found for the selected cuisine type.");
            return;
          }

          restaurants.forEach(function (restaurant) {
            if (restaurant.cuisine) {
              const cuisines = restaurant.cuisine.split(", ");
              const cuisineTags = cuisines
                .map(function (cuisine) {
                  return '<span class="tag">' + cuisine + "</span>";
                })
                .join("");

              isUserFavorite(restaurant.id, userId).then((isFavorite) => {
                const icon = isFavorite ? "myfav.svg" : "fav.svg";

                cardList.innerHTML +=
                  '<div class="card">' +
                  '<div class="card-header">' +
                  '<span class="rating">' +
                  (restaurant.average_rating || 0) +
                  '<span class="star">&#9733;</span>' +
                  '<span class="rating-count">(' +
                  restaurant.number_of_reviews +
                  "+)</span>" +
                  "</span>" +
                  '<a href="toggleFavorite?restaurant_id=' +
                  restaurant.id +
                  "&user_id=" +
                  userId +
                  '">' +
                  '<img src="../../public/data/' +
                  icon +
                  '" class="favorite-icon" />' +
                  "</a>" +
                  "</div>" +
                  '<img src="' +
                  restaurant.image_path +
                  '" alt="Restaurant Image" class="card-image" />' +
                  '<div class="card-body">' +
                  '<div class="restaurant-title">' +
                  restaurant.name +
                  '<span class="verified-icon">&#10004;</span>' +
                  "</div>" +
                  '<div class="restaurant-location">' +
                  restaurant.address +
                  ", " +
                  restaurant.city +
                  "</div>" +
                  '<div class="tags">' +
                  cuisineTags +
                  "</div>" +
                  "</div>" +
                  "</div>";
              });
              attachFavoriteIconListeners();
            } else {
              console.log(
                "Restaurant object does not have a cuisineTypes property:",
                restaurant
              );
            }
          });
        })
        .catch((error) => {
          console.error("Error:", error);
        });

      foodFilterItems.forEach(function (item) {
        item.classList.remove("active");
      });
      this.classList.add("active");
    });
  });
}

function isUserFavorite(restaurantId, userId) {
  return fetch(
    "/isFavorite?restaurant_id=" + restaurantId + "&user_id=" + userId
  )
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.text();
    })
    .then((text) => {
      console.log("Response text:", text);
      return JSON.parse(text);
    })
    .then((data) => data.isFavorite)
    .catch((error) => {
      console.error("Error:", error);
      return false;
    });
}
