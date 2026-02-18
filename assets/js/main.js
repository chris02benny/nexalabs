// NEXA FUTURE READY LAB - Main JavaScript

// Hero 3D Particles
function initHeroParticles() {
  const container = document.getElementById('heroParticles');
  if (!container) return;

  const canvas = document.createElement('canvas');
  canvas.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;pointer-events:none;';
  container.appendChild(canvas);

  const ctx = canvas.getContext('2d');
  let particles = [];
  const count = 80;

  function resize() {
    const hero = container.closest('.hero-3d');
    const w = hero ? hero.offsetWidth : window.innerWidth;
    const h = hero ? hero.offsetHeight : window.innerHeight;
    canvas.width = w;
    canvas.height = h;
    particles = [];
    for (let i = 0; i < count; i++) {
      particles.push({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        r: Math.random() * 2 + 0.5,
        vx: (Math.random() - 0.5) * 0.5,
        vy: (Math.random() - 0.5) * 0.5,
        opacity: Math.random() * 0.5 + 0.2
      });
    }
  }

  function animate() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    particles.forEach(p => {
      p.x += p.vx;
      p.y += p.vy;
      if (p.x < 0 || p.x > canvas.width) p.vx *= -1;
      if (p.y < 0 || p.y > canvas.height) p.vy *= -1;
      ctx.beginPath();
      ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
      ctx.fillStyle = `rgba(59, 130, 246, ${p.opacity})`;
      ctx.fill();
    });
    requestAnimationFrame(animate);
  }

  resize();
  window.addEventListener('resize', resize);
  animate();
}

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
    initHeroParticles();
    initFloatingElements();
    initSpotlightCards();
    initLearnerGroupsSwiper();
});

// Open Program Modal
function openProgramModal(index) {
    const dataElement = document.getElementById(`program-data-${index}`);
    if (!dataElement) return;

    const title = dataElement.querySelector('.program-modal-title').textContent;
    const icon = dataElement.querySelector('.program-modal-icon').textContent;
    const color = dataElement.querySelector('.program-modal-color').textContent;
    const focusAreas = JSON.parse(dataElement.querySelector('.program-modal-focus-areas').textContent);
    const applications = JSON.parse(dataElement.querySelector('.program-modal-applications').textContent);
    const outcome = dataElement.querySelector('.program-modal-outcome').textContent;

    // Set modal content
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalIcon').className = `bi bi-${icon}`;
    document.getElementById('modalOutcome').textContent = outcome;

    // Set color theme
    const modal = document.getElementById('programModal');
    modal.setAttribute('data-color', color);

    // Populate focus areas
    const focusAreasList = document.getElementById('modalFocusAreas');
    focusAreasList.innerHTML = '';
    focusAreas.forEach(area => {
        const li = document.createElement('li');
        li.textContent = area;
        focusAreasList.appendChild(li);
    });

    // Populate applications
    const applicationsList = document.getElementById('modalApplications');
    applicationsList.innerHTML = '';
    applications.forEach(app => {
        const li = document.createElement('li');
        li.textContent = app;
        applicationsList.appendChild(li);
    });

    // Show modal using Bootstrap
    const modalInstance = new bootstrap.Modal(document.getElementById('programModal'));
    modalInstance.show();
}
