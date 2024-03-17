// Function to handle form submission
async function handleSubmit(event) {
    event.preventDefault(); // Prevent default form submission behavior
    // Gather updated data from the form fields
    const updatedUserData = {
        budget: document.getElementById("newBudget").value
    };
    console.log(updatedUserData);
    
    try {
        // Send updated data to the server using fetch API
        const response = await fetch('/roommates/api/update-budget', {
            method: 'PATCH', // You can use 'PUT' or 'PATCH' if updating existing data
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(updatedUserData)
        });
        
        // Handle response from the server
        if (response.ok) {
            alert("Budzet je azuriran");
            // Optionally, you can reload the page or perform any other action
        } else {
            alert("Budzet nije uspeo da se izmeni");
        }
    } catch (error) {
        console.error('Error updating user data:', error);
    }
}

// Add event listener to form submission event
document.getElementById("budget-form").addEventListener("submit", handleSubmit);