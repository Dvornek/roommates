const logoutSpan = document.getElementById('logout-span');
logoutSpan.addEventListener('click', async function() {
    try {
        const response = await fetch('/roommates/api/logout', {
            method: 'POST',
        });
        if (response.ok) {
            window.location.href = '/roommates/home'; // Redirect to homepage
        } else {
            console.error('Logout failed:', response.statusText);
        }
    } catch (error) {
        console.error('Logout failed:', error);
    }
});
