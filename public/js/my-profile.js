// Function to fetch user data asynchronously
async function fetchUserData() {
    try {
        const response = await fetch('/roommates/api/users');
        const userData = await response.json();
        return userData;
    } catch (error) {
        console.error('Error fetching user data:', error);
    }
}

// Function to populate spans with fetched data
async function populateUserData() {
    const userData = await fetchUserData();
    if (userData) {
        // Populate spans
        document.getElementById("rating").textContent = userData.user.rating;
        document.getElementById("fname").textContent = userData.user.fname;
        document.getElementById("lname").textContent = userData.user.lname;
        document.getElementById("dob").textContent = userData.user.dob;
        document.getElementById("email").textContent = userData.user.email;
        document.getElementById("telephone").textContent = userData.user.telephone;
        document.getElementById("city").textContent = userData.user.city;
        document.getElementById("budget").textContent = userData.user.budget;
        document.getElementById("description").textContent = userData.user.description;

        document.getElementById("user-fname").value = userData.user.fname
        document.getElementById("user-lname").value = userData.user.lname
        document.getElementById("user-email").value = userData.user.email
        document.getElementById("user-telephone").value = userData.user.telephone
        document.getElementById("user-city").value= userData.user.city
    }
}

// Call the function to populate user data when the page loads
populateUserData();