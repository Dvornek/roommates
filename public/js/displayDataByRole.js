async function updateUserRole() {
    try {
        const response = await fetch('/roommates/api/role');
        const data = await response.json();
        if (data.role === 'guest') {
            // Hide logout link
            // document.querySelector('.nav-item-logout').style.display = 'none';
            // Show login and registration links
            document.querySelector('#logout-span').style.display = 'none';
            document.querySelector('#my-account').style.display = 'none';
            document.querySelector('#loginLink').style.display = 'block';
            document.querySelector('#registerLink').style.display = 'block';
            // document.querySelector('.nav-item-registration').style.display = 'block';
        } else {
            // Hide login and registration links
            // document.querySelector('.nav-item-login').style.display = 'none';
            // document.querySelector('.nav-item-registration').style.display = 'none';
            // Show logout link
            document.querySelector('#logout-span').style.display = 'block';
            document.querySelector('#my-account').style.display = 'block';
            document.querySelector('#loginLink').style.display = 'none';
            document.querySelector('#registerLink').style.display = 'none';
        }
    } catch (error) {
        console.error('Error updating user role:', error);
    }
}

// Call updateUserRole function when the page loads
window.addEventListener('DOMContentLoaded', updateUserRole);