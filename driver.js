document.getElementById('driver-registration-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('register_driver.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            this.reset();
            renderDrivers(data.drivers);
        }
    })
    .catch(err => {
        console.error('Error:', err);
    });
});

function renderDrivers(drivers) {
    const container = document.getElementById('drivers-container');
    container.innerHTML = '<h3>Registered Drivers</h3>';

    if (drivers.length === 0) {
        container.innerHTML += '<p>No drivers registered yet.</p>';
        return;
    }

    const list = document.createElement('ul');
    drivers.forEach(driver => {
        const item = document.createElement('li');
        item.textContent = `License #: ${driver.license_number}, Class: ${driver.license_class}, Registered: ${driver.registered_at}`;
        list.appendChild(item);
    });

    container.appendChild(list);
}
// Fetch drivers when the page loads
window.addEventListener('DOMContentLoaded', () => {
    fetch('get_drivers.php')
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                renderDrivers(data.drivers);
            }
        })
        .catch(err => {
            console.error('Failed to load drivers:', err);
        });
});
