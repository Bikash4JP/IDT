document.addEventListener('DOMContentLoaded', function() {
    const bars = document.querySelectorAll('.jlpt-bar');
    bars.forEach((bar, index) => {
      bar.style.setProperty('--jlpt-final-height', bar.style.height);
      bar.style.setProperty('--jlpt-order', index);
    });
});

// Phone call JS 
document.addEventListener("DOMContentLoaded", function () {
    const phoneLink = document.querySelector(".phone-link");

    phoneLink.addEventListener("click", function (e) {
        const isMobile = /Mobi|Android/i.test(navigator.userAgent);
        if (!isMobile) {
            alert("This link will try to start a phone call.");
        }
        // For mobile, the browser will handle `tel:` automatically.
    });
});

// Mail redirectors JS
document.addEventListener("DOMContentLoaded", function () {
    const mailButton = document.getElementById("mailBtn");

    mailButton.addEventListener("click", function () {
        window.location.href = "mailto:info@it-future.jp";
    });
});

// JavaScript to handle sticky behavior on mobile for the shortcuts
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

window.addEventListener('scroll', debounce(function() {
    const shortcutLinks = document.querySelector('.shortcut-links');
    const header = document.querySelector('#header');
    const headerHeight = header ? header.offsetHeight : 0;
    const introSection = document.querySelector('.topSlider'); // Updated to target the new intro section
    const introBottom = introSection ? (introSection.offsetTop + introSection.offsetHeight) : 0;

    if (window.scrollY >= introBottom - headerHeight) {
        shortcutLinks.classList.add('sticky');
        shortcutLinks.style.top = headerHeight + 'px';
    } else {
        shortcutLinks.classList.remove('sticky');
        shortcutLinks.style.top = 'auto';
    }
}, 50)); // Debounce delay of 50ms

// Back to Top Button Functionality
document.addEventListener('DOMContentLoaded', () => {
    const backToTopButton = document.getElementById('back-to-top');

    // Show/hide button based on scroll position
    window.addEventListener('scroll', () => {
        const scrollPosition = window.scrollY;
        const viewportHeight = window.innerHeight;

        if (scrollPosition > viewportHeight) {
            backToTopButton.classList.add('visible');
        } else {
            backToTopButton.classList.remove('visible');
        }
    });

    // Smooth scroll to top on click
    backToTopButton.addEventListener('click', (e) => {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    const bars = document.querySelectorAll('.jlpt-bar');
    bars.forEach((bar, index) => {
      bar.style.setProperty('--jlpt-final-height', bar.style.height);
      bar.style.setProperty('--jlpt-order', index);
    });
});

// Phone call JS 
document.addEventListener("DOMContentLoaded", function () {
    const phoneLink = document.querySelector(".phone-link");

    phoneLink.addEventListener("click", function (e) {
        const isMobile = /Mobi|Android/i.test(navigator.userAgent);
        if (!isMobile) {
            alert("This link will try to start a phone call.");
        }
        // For mobile, the browser will handle `tel:` automatically.
    });
});

// Mail redirectors JS
document.addEventListener("DOMContentLoaded", function () {
    const mailButton = document.getElementById("mailBtn");

    mailButton.addEventListener("click", function () {
        window.location.href = "mailto:info@it-future.jp";
    });
});

// JavaScript to handle sticky behavior on mobile for the shortcuts
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

window.addEventListener('scroll', debounce(function() {
    const shortcutLinks = document.querySelector('.shortcut-links');
    const header = document.querySelector('#header');
    const headerHeight = header ? header.offsetHeight : 0;
    const introSection = document.querySelector('.topSlider');
    const introBottom = introSection ? (introSection.offsetTop + introSection.offsetHeight) : 0;

    if (window.scrollY >= introBottom - headerHeight) {
        shortcutLinks.classList.add('sticky');
        shortcutLinks.style.top = headerHeight + 'px';
    } else {
        shortcutLinks.classList.remove('sticky');
        shortcutLinks.style.top = 'auto';
    }
}, 50));

// Back to Top Button Functionality
document.addEventListener('DOMContentLoaded', () => {
    const backToTopButton = document.getElementById('back-to-top');

    // Show/hide button based on scroll position
    window.addEventListener('scroll', () => {
        const scrollPosition = window.scrollY;
        const viewportHeight = window.innerHeight;

        if (scrollPosition > viewportHeight) {
            backToTopButton.classList.add('visible');
        } else {
            backToTopButton.classList.remove('visible');
        }
    });

    // Smooth scroll to top on click
    backToTopButton.addEventListener('click', (e) => {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});