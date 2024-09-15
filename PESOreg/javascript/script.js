document
  .getElementById("registrationForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent default form submission

    // Collect form data
    let formData = {
      name: document.getElementById("name").value,
      age: document.getElementById("age").value,
      dob: document.getElementById("dob").value,
      contactNumber: document.getElementById("contactNumber").value,
      gmail: document.getElementById("gmail").value,
      religion: document.getElementById("religion").value,
      address: document.getElementById("address").value,
      province: document.getElementById("province").value,
      purpose: document.getElementById("purpose").value,
      regDate: document.getElementById("regDate").value, // Get user input for registration date
    };

    // AJAX request to submit form data to PHP
    fetch("http://localhost/PESOreg/ajax/registration.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(formData),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Network response was not ok: " + response.statusText);
        }
        return response.text(); // Read raw response text
      })
      .then((text) => {
        try {
          // Try to parse the response as JSON
          const data = JSON.parse(text);
          document.getElementById("response").textContent = data.message;
        } catch (error) {
          // Log the error and response text
          console.error("Error parsing JSON:", error);
          console.log("Raw response:", text);
          document.getElementById("response").textContent =
            "Invalid server response.";
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        document.getElementById("response").textContent =
          "There was an error processing the request.";
      });
  });
