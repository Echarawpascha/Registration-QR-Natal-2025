// Navbar functionality
function toggleProfileMenu() {
    const profileMenu = document.getElementById('profile-menu');
    const profileButton = document.querySelector('.profile-button');

    // Close mobile menu if open
    closeMobileMenu();

    // Toggle profile menu
    profileMenu.classList.toggle('show');
    profileButton.classList.toggle('active');
}

function toggleMobileMenu() {
    const navbarMenu = document.getElementById('navbar-menu');
    const overlay = document.getElementById('overlay');

    navbarMenu.classList.toggle('show');
    overlay.classList.toggle('show');
}

function closeMobileMenu() {
    const navbarMenu = document.getElementById('navbar-menu');
    const overlay = document.getElementById('overlay');

    navbarMenu.classList.remove('show');
    overlay.classList.remove('show');
}

// Close menus when clicking outside
document.addEventListener('click', function(e) {
    const profileMenu = document.getElementById('profile-menu');
    const profileButton = document.querySelector('.profile-button');
    const navbarMenu = document.getElementById('navbar-menu');
    const overlay = document.getElementById('overlay');

    // Close profile menu if clicked outside
    if (!e.target.closest('.navbar-profile')) {
        profileMenu.classList.remove('show');
        profileButton.classList.remove('active');
    }

    // Close mobile menu if clicked outside
    if (!e.target.closest('.navbar') && !e.target.closest('.mobile-menu-toggle')) {
        closeMobileMenu();
    }
});

// Close mobile menu on window resize
window.addEventListener('resize', function() {
    if (window.innerWidth > 768) {
        closeMobileMenu();
    }
});
