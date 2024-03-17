document.addEventListener('DOMContentLoaded', function(event) {
    event.preventDefault();
    // Define the email you want to fetch data for
    const email = localStorage.getItem('profileEmail');
    console.log(email);
    // Call the function to fetch user data by email
    fetchUserDataByEmail(email);


    const form = document.querySelector('#form-rating');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const rating = document.getElementById('ratingInput').value;
        rateUser(email, rating);
    });
});

async function fetchUserDataByEmail(email) {
    try {
        const response = await fetch('/roommates/api/display-user', {
            method: 'POST', // Use POST method
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                email: email
            })
        });
        const userData = await response.json();
        if (response.ok) {
            // Data successfully fetched
            if(!userData.user.rating)userData.user.rating = 'Nema ocenu'
            console.log("User data fetched successfully");
            if(!userData.user.budget)userData.user.budget = 'Korisnik nije uneo budžet';
            document.getElementById('rating').textContent = userData.user.rating;
            document.getElementById('fname').textContent = userData.user.fname;
            document.getElementById('lname').textContent = userData.user.lname;
            document.getElementById('dob').textContent = userData.user.dob;
            document.getElementById('email').textContent = userData.user.email;
            document.getElementById('telephone').textContent = userData.user.telephone;
            document.getElementById('budget').textContent = userData.user.budget;
        } else {
            console.error("Error fetching user data:", userData.message);
        }
    } catch (error) {
        console.error('Error fetching user data:', error);
    }
}
async function rateUser(email, rating) {
    try {
        const response = await fetch('/roommates/api/rate-user', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                email: email,
                rating: rating
            })
        });
        console.log(email);
        console.log(rating);
        const data = await response.json();
        console.log(data);
        if (response.ok) {
            console.log("User rated successfully");
            location.reload();
        } else {
            console.error("Error rating user:", data.message);
        }
    } catch (error) {
        console.error('Error rating user:', error);
    }
}