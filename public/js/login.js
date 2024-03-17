const loginForm = document.getElementById('login-form');
// const loginError = document.querySelector('.login-error');

loginForm.addEventListener('submit', async function(event) {
        event.preventDefault();
        // Grab values directly from input elements
        const userEmail = document.getElementById('mail');
        const userPassword = document.getElementById('pass');
        try {
            const response = await fetch('/roommates/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    email: userEmail.value,
                    password: userPassword.value
                })
            });
            const data = await response.json();
            console.log(data);
            if (response.ok) {
                // Redirect to homepage after successful login
                window.location.href = '/roommates/home';
            } else {
                // Login failure
                userPassword.value='';
                alert("Pogresna lozinka");
                // loginError.textContent = 'Не тaчна е-адреса или лозинка.';
            }
        } catch (error) {
            console.error('Login failed:', error);
            alert('Login failed. Please try again later.');
        }
    });
    