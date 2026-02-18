// NEXA FUTURE READY LAB - Main JavaScript

// Mobile Navigation Toggle
document.addEventListener('DOMContentLoaded', function () {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarNav = document.querySelector('.navbar-nav');

    if (navbarToggler && navbarNav) {
        navbarToggler.addEventListener('click', function () {
            navbarNav.classList.toggle('show');
            navbarToggler.classList.toggle('active');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function (event) {
            if (!event.target.closest('.navbar')) {
                navbarNav.classList.remove('show');
                navbarToggler.classList.remove('active');
            }
        });
    }

    // Scroll-triggered animations using Intersection Observer
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all elements with data-animate attribute
    document.querySelectorAll('[data-animate]').forEach(el => {
        observer.observe(el);
    });

    // Form validation enhancement
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.style.borderColor = 'hsl(0, 84%, 60%)';
                } else {
                    input.style.borderColor = '';
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Floating element animation helper
function initFloatingElements() {
    const floatingElements = document.querySelectorAll('.floating-element');
    floatingElements.forEach((el, index) => {
        el.style.animationDelay = `${index * 0.5}s`;
    });
}

// Spotlight Card Effect
function initSpotlightCards() {
    const spotlightCards = document.querySelectorAll('.program-detail-card, .learner-group-card');

    spotlightCards.forEach(card => {
        card.addEventListener('mousemove', function (e) {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            card.style.setProperty('--mouse-x', `${x}px`);
            card.style.setProperty('--mouse-y', `${y}px`);
        });

        // Reset position when mouse leaves
        card.addEventListener('mouseleave', function () {
            card.style.setProperty('--mouse-x', '50%');
            card.style.setProperty('--mouse-y', '50%');
        });
    });
}

// Swiper Initialization
function initLearnerGroupsSwiper() {
    if (document.querySelector('.learnerGroupsSwiper')) {
        new Swiper('.learnerGroupsSwiper', {
            slidesPerView: 1,
            spaceBetween: 40,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.learner-groups-next',
                prevEl: '.learner-groups-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            }
        });
    }
}

// Initialize on page load
window.addEventListener('load', function () {
    initFloatingElements();
    initSpotlightCards();
    initLearnerGroupsSwiper();
});

// Toggle Program Details
function toggleProgramDetails(index, event) {
    const content = document.getElementById(`program-${index}`);
    const button = event.currentTarget;
    const btnText = button.querySelector('.details-btn-text');
    const btnIcon = button.querySelector('.details-btn-icon');

    const isExpanding = !content.classList.contains('active');

    // Close all other open program details
    document.querySelectorAll('.program-details-content.active').forEach(otherContent => {
        if (otherContent !== content) {
            otherContent.classList.remove('active');
            // Update the button of the other closed card
            const otherCard = otherContent.closest('.program-detail-card');
            const otherBtnText = otherCard.querySelector('.details-btn-text');
            const otherBtnIcon = otherCard.querySelector('.details-btn-icon');
            if (otherBtnText) otherBtnText.textContent = 'Show Details';
            if (otherBtnIcon) {
                otherBtnIcon.classList.remove('bi-chevron-up');
                otherBtnIcon.classList.add('bi-chevron-down');
            }
        }
    });

    // Toggle the clicked one
    content.classList.toggle('active');

    if (content.classList.contains('active')) {
        btnText.textContent = 'Hide Details';
        btnIcon.classList.remove('bi-chevron-down');
        btnIcon.classList.add('bi-chevron-up');
    } else {
        btnText.textContent = 'Show Details';
        btnIcon.classList.remove('bi-chevron-up');
        btnIcon.classList.add('bi-chevron-down');
    }
}
