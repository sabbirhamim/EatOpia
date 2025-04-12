const restaurants = [
    { name: "Tasty Bites", img: "assets/images/r1.jpg" },
    { name: "Foodie Hub", img: "assets/images/r2.jpg" },
    { name: "Flavor Town", img: "assets/images/r3.jpg" },
    { name: "Spice Junction", img: "assets/images/r7.jpg" },
    { name: "Royal Feast", img: "assets/images/r5.jpg" }
];

const restaurantList = document.getElementById("restaurant-list");

restaurants.forEach(restaurant => {
    let restaurantCard = `
        <div class="restaurant-card">
            <img src="${restaurant.img}" alt="${restaurant.name} Image">
            <h3>${restaurant.name}</h3>
            <a href="menu/restaurant_menu.php?name=${encodeURIComponent(restaurant.name)}">
                <button class="view-menu-btn">View Menu</button>
            </a>
        </div>
    `;
    restaurantList.innerHTML += restaurantCard;
});
