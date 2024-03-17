// Function to handle form submission
async function handleSubmit(event) {
    event.preventDefault(); // Prevent default form submission behavior

    // Gather updated data from the form fields
    const updatedUserData = {
        password: document.getElementById("user-password").value,
        confirmPassword: document.getElementById("user-confirmPassword").value
        // Add more fields as needed
    };

    try {
        // Send updated data to the server using fetch API
        const response = await fetch('/roommates/api/password-change', {
            method: 'PATCH', // You can use 'PUT' or 'PATCH' if updating existing data
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(updatedUserData)
        });

        // Handle response from the server
        if (response.ok) {
            alert("lozinka promenjena");
            // Optionally, you can reload the page or perform any other action
        } else {
            alert("Lozinke se ne podudaraju");
        }
    } catch (error) {
        console.error('Error updating user data:', error);
    }
}

// Add event listener to form submission event
document.getElementById("password-form").addEventListener("submit", handleSubmit);