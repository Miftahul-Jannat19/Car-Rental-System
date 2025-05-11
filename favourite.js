function fetchAllCars() {
  fetch("get_all_cars.php")
    .then(res => res.json())
    .then(cars => {
      const container = document.getElementById("all-cars");
      container.innerHTML = "";
      cars.forEach(car => {
        const div = document.createElement("div");
        div.className = "car-card";

        div.innerHTML = `
          <img src="${car.image}" alt="${car.model}">
          <h4>${car.registrationNumber}</h4>
          <p>${car.model}</p>
          <button onclick="markFavourite(${car.id})">Mark as Favourite</button>
        `;
        container.appendChild(div);
      });
    });
}

function markFavourite(carId) {
  fetch("mark_favourite.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ carId: carId })
  })
  .then(res => res.json())
  .then(res => {
    if (res.success) {
      loadFavourites();
    } else {
      alert("Failed to mark favourite");
    }
  });
}

function unmarkFavourite(carId) {
  fetch("unmark_favourite.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ carId: carId })
  })
  .then(res => res.json())
  .then(res => {
    if (res.success) {
      loadFavourites();
    } else {
      alert("Failed to unmark favourite");
    }
  });
}

function loadFavourites() {
  fetch("get_favourites.php")
    .then(res => res.json())
    .then(data => {
      const container = document.getElementById("favourites");
      container.innerHTML = "";
      data.forEach(car => {
        const div = document.createElement("div");
        div.className = "car-card";

        div.innerHTML = `
          <img src="${car.image}" alt="${car.model}">
          <h4>${car.registrationNumber}</h4>
          <p>${car.model}</p>
          <button class="unmark" onclick="unmarkFavourite(${car.id})">Unmark</button>
        `;
        container.appendChild(div);
      });
    });
}

window.onload = () => {
  fetchAllCars();
  loadFavourites();
};
