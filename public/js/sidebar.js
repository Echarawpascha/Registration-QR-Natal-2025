// Profile popup menu functionality
document.addEventListener('DOMContentLoaded', function() {
    console.log('Sidebar JS loaded');

    const profileButtons = document.querySelectorAll('.profile-button');
    const popupMenus = document.querySelectorAll('.popup-menu');

    console.log('Found profile buttons:', profileButtons.length);
    console.log('Found popup menus:', popupMenus.length);

    profileButtons.forEach((button, index) => {
        const popupMenu = popupMenus[index];

        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            console.log('Profile button clicked:', index);

            // Close all other popup menus
            popupMenus.forEach((menu, menuIndex) => {
                if (menuIndex !== index) {
                    menu.classList.remove('show');
                    profileButtons[menuIndex].classList.remove('active');
                }
            });

            // Toggle current popup menu
            popupMenu.classList.toggle('show');
            button.classList.toggle('active');

            console.log('Popup menu toggled:', popupMenu.classList.contains('show'));
        });
    });

    // Close popup when clicking outside
    document.addEventListener('click', function(e) {
        const isInsideProfileSection = e.target.closest('.profile-section');

        if (!isInsideProfileSection) {
            console.log('Clicked outside profile section, closing menus');
            popupMenus.forEach(menu => menu.classList.remove('show'));
            profileButtons.forEach(button => button.classList.remove('active'));
        }
    });

    // Mobile sidebar toggle (if needed)
    const menuBtns = document.querySelectorAll(".menu-icon");
    const navBar = document.querySelector("nav");
    const overlay = document.querySelector(".overlay");

    if (menuBtns.length > 0 && navBar && overlay) {
        menuBtns.forEach((menuBtn) => {
            menuBtn.addEventListener("click", () => {
                navBar.classList.toggle("open");
            });
        });

        overlay.addEventListener("click", () => {
            navBar.classList.remove("open");
        });
    }
});
