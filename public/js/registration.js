const emailDiv = document.querySelector('.email-div');
const passwordDiv = document.querySelector('.password-div');
const confirmPasswordDiv = document.querySelector('.confirm-password-div');
const fnameDiv = document.querySelector('.fname-div');
const lnameDiv = document.querySelector('.lname-div');
const telephoneDiv = document.querySelector('.telephone-div');
const genderDiv = document.querySelector('.gender-div');
const dobDiv = document.querySelector('.dob-div');

// Function to register a user
async function registerUser(event) {
    // Prevent default page redirection
    event.preventDefault();
    try {
        // Create FormData object from form
        const formData = new FormData(event.target);
        const userData = {};
        // Iterate over form data entries and populate the userData object
        for (const [key, value] of formData.entries()) {
            userData[key] = value;
        }
        console.log(userData);
         // Send registration request
         const response = await fetch('/roommates/api/users', {
            method: 'POST',
            body: JSON.stringify(userData)
        });
        // Parse JSON response
        const data = await response.json();
        if (response.ok) {
            // Successful registration, redirect to home page
            window.location.href = '/roommates/home';
        } else {
             // Set display to "none" for all div elements initially
             emailDiv.style.display = 'none';
             passwordDiv.style.display = 'none';
             confirmPasswordDiv.style.display = 'none';
             fnameDiv.style.display = 'none';
             lnameDiv.style.display = 'none';
             telephoneDiv.style.display = 'none';
            // Display validation messages in respective div elements
            if (data.errors.email) {
                emailDiv.innerText = data.errors.email;
                emailDiv.style.display ='block';
            }
            if (data.errors.password) {
                passwordDiv.innerText = data.errors.password;
                passwordDiv.style.display ='block';
            }
            if (data.errors.confirmPassword) {
                confirmPasswordDiv.innerText = data.errors.confirmPassword;
                confirmPasswordDiv.style.display ='block';
            }
            if (data.errors.fname) {
                fnameDiv.innerText = data.errors.fname;
                fnameDiv.style.display ='block';
            }
            if (data.errors.lname) {
                lnameDiv.innerText = data.errors.lname;
                lnameDiv.style.display ='block';
            }
            if (data.errors.telephone) {
                telephoneDiv.innerText = data.errors.telephone;
                telephoneDiv.style.display ='block';
            }       
        }
    } catch (error) {
        console.error('Error during registration:', error);
        alert('Грешка приликом регистрације');
    }
}
// Add event listener to the registration form
document.getElementById("registration-form")
    .addEventListener('submit', registerUser);