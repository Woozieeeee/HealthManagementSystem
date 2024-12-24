// resources/js/custom/navbar.js

document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.getElementById('navbar');
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    let isScrolling;

    // Scroll Detection for Navbar
    window.addEventListener('scroll', function () {
        // Add 'scrolled' class to navbar when scrolling
        navbar.classList.add('scrolled');

        // Clear the timeout to detect when scrolling stops
        clearTimeout(isScrolling);

        // Set a timeout to trigger after scrolling stops
        isScrolling = setTimeout(function () {
            // Remove 'scrolled' class when scrolling stops
            navbar.classList.remove('scrolled');
        }, 150); // Adjust the delay (150ms) if needed
    });

    // Dark Mode Toggle Functionality
    darkModeToggle.addEventListener('click', function () {
        document.body.classList.toggle('dark-mode');
        updateDarkModeToggleIcon();
        saveDarkModePreference();
    });

    // Update Toggle Button's Icon
    function updateDarkModeToggleIcon() {
        if (document.body.classList.contains('dark-mode')) {
            darkModeToggle.innerHTML = '<i class="fas fa-sun"></i>';
            darkModeToggle.setAttribute('aria-label', 'Switch to Light Mode');
        } else {
            darkModeToggle.innerHTML = '<i class="fas fa-moon"></i>';
            darkModeToggle.setAttribute('aria-label', 'Switch to Dark Mode');
        }
    }

    // Save Dark Mode Preference in Local Storage
    function saveDarkModePreference() {
        if (document.body.classList.contains('dark-mode')) {
            localStorage.setItem('dark-mode', 'enabled');
        } else {
            localStorage.setItem('dark-mode', 'disabled');
        }
    }

    // Load Dark Mode Preference from Local Storage
    function loadDarkModePreference() {
        const darkMode = localStorage.getItem('dark-mode');
        if (darkMode === 'enabled') {
            document.body.classList.add('dark-mode');
            updateDarkModeToggleIcon();
        } else {
            document.body.classList.remove('dark-mode');
            updateDarkModeToggleIcon();
        }
    }

    // Initialize Dark Mode Based on Preference
    loadDarkModePreference();
});

// contact 



