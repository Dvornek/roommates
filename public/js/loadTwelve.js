document.addEventListener("DOMContentLoaded", function () {
    const usersContainer = document.getElementById("usersContainer");
    const noResult = document.getElementById("noResult");

    fetch("/roommates/api/fetch-twelve")
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                noResult.style.display = "block";
            } else {
                console.log(data);
                data.users.forEach(user => {
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
        })
        .catch(error => {
            console.error("Error fetching data:", error);
            // Display error message if needed
        });
});