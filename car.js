let cars = [];
let currentIndex = 0;

// Register car
document.getElementById("car-registration-form").addEventListener("submit", function (e) {
  e.preventDefault();

  const formData = {
    registrationNumber: document.getElementById("registration-number").value,
    category: document.getElementById("category").value,
    seatCapacity: parseInt(document.getElementById("seat-capacity").value),
    make: document.getElementById("make").value,
    year: document.getElementById("year").value,
    model: document.getElementById("model").value,
  };

  fetch("http://localhost/carrus(front end)final/register_car.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(formData),
  })
    .then(response => response.json())
    .then(data => {
      alert(data.message);
      document.getElementById("car-registration-form").reset();
    })
    .catch(err => alert("Error: " + err));
});

// Load cars
document.getElementById("load-cars").addEventListener("click", function () {
  fetch("http://localhost/carrus(front end)final/get_cars.php")
    .then(response => response.json())
    .then(data => {
      cars = data;
      currentIndex = 0;

      if (cars.length > 0) {
        displayCar(cars[currentIndex]);
        toggleNavigationButtons(true);
      } else {
        document.getElementById("single-car-display").innerHTML = "<p>No registered cars found.</p>";
        toggleNavigationButtons(false);
      }
    })
    .catch(err => {
      console.error("Error loading cars:", err);
    });
});

// Display one car at a time
function displayCar(car) {
  const list = document.getElementById("single-car-display");
  list.innerHTML = `
    <div class="car-card">
      <h4>${car.registrationNumber}</h4>
      <p><strong>Make:</strong> ${car.make}</p>
      <p><strong>Model:</strong> ${car.model}</p>
      <p><strong>Year:</strong> ${car.year}</p>
      <p><strong>Seats:</strong> ${car.seatCapacity}</p>
      <p><strong>Category:</strong> ${car.category}</p>
    </div>
  `;
}

// Handle next button
document.getElementById("next-car").addEventListener("click", function () {
  if (cars.length > 0) {
    currentIndex = (currentIndex + 1) % cars.length;
    displayCar(cars[currentIndex]);
  }
});

// Toggle next button visibility
function toggleNavigationButtons(show) {
  document.getElementById("next-car").style.display = show ? "inline-block" : "none";
}
