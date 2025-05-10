document.addEventListener('DOMContentLoaded', function () {
    const carSelect = document.getElementById('car');
    const form = document.getElementById('car-rental-form');
    const costValue = document.getElementById('cost-value');

    // Fetch car options
    fetch('get_cars.php')
        .then(response => response.json())
        .then(cars => {
            cars.forEach(car => {
                const option = document.createElement('option');
                option.value = car.id;
                option.textContent = `${car.make} ${car.model}`;
                carSelect.appendChild(option);
            });
        });

    // Update total cost on form change
    form.addEventListener('change', function () {
        const carId = carSelect.value;
        const driverOption = document.getElementById('driver-option').value;
        const subscriptionDuration = document.getElementById('subscription-duration').value;
        const offerCode = document.getElementById('offer-code').value;

        fetch(`get_car_details.php?car_id=${carId}`)
            .then(response => response.json())
            .then(car => {
                const baseRate = car.fixed_rate;
                const driverFee = driverOption === 'driver' ? 500 : 0;
                let totalCost = (baseRate * subscriptionDuration) + driverFee;

                // Apply offer if exists
                if (offerCode) {
                    // Assuming a 10% discount for valid offer code
                    totalCost -= totalCost * 0.1;
                }

                costValue.textContent = totalCost.toFixed(2);
            });
    });

    // Submit booking
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => data[key] = value);

        fetch('car_rental.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    alert('Booking Successful!');
                    form.reset();
                } else {
                    alert('Error: ' + result.message);
                }
            })
            .catch(error => console.error('Error:', error));
    });
});
