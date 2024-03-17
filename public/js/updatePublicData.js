// Function to handle form submission
async function handleSubmit(event) {
    event.preventDefault(); // Prevent default form submission behavior

    // Gather updated data from the form fields
    const updatedUserData = {
        fname: document.getElementById("user-fname").value,
        lname: document.getElementById("user-lname").value,
        email: document.getElementById("user-email").value,
        telephone: document.getElementById("user-telephone").value,
        city: document.getElementById("user-city").value
        // Add more fields as needed
    };

    try {
        // Send updated data to the server using fetch API
        const response = await fetch('/roommates/api/users', {
            method: 'PATCH', // You can use 'PUT' or 'PATCH' if updating existing data
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(updatedUserData)
        });

        // Handle response from the server
        if (response.ok) {
            console.log('User data updated successfully');
            // Optionally, you can reload the page or perform any other action
        } else {
            console.error('Failed to update user data');
        }
    } catch (error) {
        console.error('Error updating user data:', error);
    }
}

// Add event listener to form submission event
document.getElementById("edit-form").addEventListener("submit", handleSubmit);