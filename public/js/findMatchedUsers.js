const form = document.getElementById("search");
form.addEventListener("submit", async function(event) {
    event.preventDefault();
    const city = document.getElementById("citySearchInput").value;
    const budget = document.getElementById("slider").value;
    await getUsers(city,budget);
});

async function getUsers(city,budget) {
    try {
        // window.location = '/roommates/home';
        //  Remove previously created spans
        const usersContainer = document.getElementById("usersContainer");
        usersContainer.innerHTML = "";
        
        const response = await fetch('/roommates/api/fetch-users-with-same-parameters', {
            method: 'POST', // Use POST method
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                city: city,
                budget:budget,
            })
        });
        const data = await response.json();
        console.log(data);
        if (data.length === 0) {
            noResult.style.display = "block";
        } else {
            console.log(data);
            data.user.forEach(user => {
                const option = document.createElement("div");
                option.classList.add("option");

                const emailSpan = document.createElement("span");
                emailSpan.textContent = '\nEmail:\n'+user.email;
                option.appendChild(emailSpan);

                const fnameSpan = document.createElement("span");
                fnameSpan.textContent ='\nIme:\n'+ user.fname;
                option.appendChild(fnameSpan);

                const lnameSpan = document.createElement("span");
                lnameSpan.textContent = '\nPrezime:\n'+user.lname;
                option.appendChild(lnameSpan);

                const ratingSpan = document.createElement("span");
                ratingSpan.textContent = '\nOcena:\n'+user.rating;
                option.appendChild(ratingSpan);

                // Add click event listener to each card
                option.addEventListener('click', function() {
                    localStorage.setItem('profileEmail', user.email);
                    // Navigate to the new page with email as a query parameter
                    window.location.href = `/roommates/display-profile`;
                });

                usersContainer.appendChild(option);
            });
        }
    } catch (error) {
        console.error('Error:', error);
    }
}
