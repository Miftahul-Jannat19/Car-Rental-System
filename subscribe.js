 console.log("JS is loaded");
const MONTHLY_RATE = 8000;
const DRIVER_SALARY = 3000;

document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('duration').addEventListener('change', calculatePrice);
  document.getElementById('driver').addEventListener('change', calculatePrice);
  calculatePrice(); // Trigger once on load

  document.getElementById('subscription-form').addEventListener('submit', simulatePayment);
});

function calculatePrice() {
  const duration = parseInt(document.getElementById('duration').value);
  const driver = document.getElementById('driver').value === 'yes';
  let total = MONTHLY_RATE * duration;
  if (driver) total += DRIVER_SALARY * duration;

  document.getElementById('price').value = total.toFixed(2);
  document.getElementById('amount').value = total.toFixed(2);
}

function simulatePayment(event) {
  event.preventDefault();

  const data = {
    carId: document.getElementById('car').value,
    startDate: document.getElementById('start-date').value,
    duration: document.getElementById('duration').value,
    address: document.getElementById('address').value,
    driver: document.getElementById('driver').value,
    price: document.getElementById('amount').value,
    transaction: document.getElementById('transaction-number').value
  };

  fetch('process_subscription.php', {  // Correct filename here
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify(data)
  })
  .then(res => res.json())
  .then(res => {
    if (res.success) {
      alert("Subscription successful!");
      window.location.reload();
    } else {
      alert("Failed: " + res.message);
    }
  })
  .catch(() => alert("Error occurred while processing payment."));
}
