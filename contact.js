document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("contact-form");
  
    form.addEventListener("submit", function (e) {
      e.preventDefault(); // Prevent default form submit
  
      const formData = new FormData(form);
  
      fetch("http://localhost/carrus(front end)final/contact.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.text())
        .then((data) => {
          alert(data); // Show response from PHP (success or error)
          form.reset(); // Clear the form
        })
        .catch((error) => {
          console.error("Error:", error);
          alert("Something went wrong. Please try again.");
        });
    });
  });
  