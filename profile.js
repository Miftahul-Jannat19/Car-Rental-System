function loadProfile() {
  fetch('session_info.php')
    .then(res => res.json())
    .then(data => {
      if (!data.loggedIn) return window.location.href = 'login.html';
      localStorage.setItem('userId', data.userId);

      fetch(`get_user_info.php?id=${data.userId}`)
        .then(res => res.json())
        .then(user => {
          if (user.error) return alert(user.error);
          document.getElementById('profile-name').textContent = user.name;
          document.getElementById('profile-email').textContent = user.email;
          document.getElementById('profile-phone').textContent = user.phone;
          document.getElementById('profile-nid').textContent = user.nid;
        });

      fetch(`get_bookings.php?userId=${data.userId}`)
        .then(res => res.json())
        .then(displayBookings);
    });
}

function displayBookings(bookings) {
  const container = document.getElementById('bookings-container');
  container.innerHTML = '';
  let total = 0, active = 0, cancelled = 0;

  bookings.forEach(b => {
    total++;
    if (b.status === 'cancelled') cancelled++;
    else active++;

    const card = document.createElement('div');
    card.className = 'booking-card';
    card.innerHTML = `
      <p><strong>Car:</strong> ${b.make} ${b.model} (${b.year})</p>
      <p><strong>Driver:</strong> ${b.driver_name || 'No Driver'}</p>
      <p><strong>Payment:</strong> $${b.payment}</p>
      <p><strong>Status:</strong> ${b.status}</p>
      <p><strong>Date:</strong> ${b.booking_date}</p>
      ${b.status !== 'cancelled' ? `<button class="cancel-btn" onclick="cancelBooking(${b.id})">Cancel</button>` : ''}
    `;
    container.appendChild(card);
  });

  document.getElementById('total-bookings').textContent = total;
  document.getElementById('active-bookings').textContent = active;
  document.getElementById('cancelled-bookings').textContent = cancelled;
}

function cancelBooking(id) {
  if (!confirm('Are you sure you want to cancel this booking?')) return;
  fetch(`cancel_booking.php?id=${id}`)
    .then(res => res.text())
    .then(() => loadProfile());
}

function filterBookings() {
  const status = document.getElementById('filter-status').value;
  const date = document.getElementById('filter-date').value;
  const userId = localStorage.getItem('userId');

  fetch(`get_bookings.php?userId=${userId}&status=${status}&date=${date}`)
    .then(res => res.json())
    .then(displayBookings);
}

document.addEventListener('DOMContentLoaded', loadProfile);
