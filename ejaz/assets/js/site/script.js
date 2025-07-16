// Initialize AOS Animation
AOS.init({
    duration: 1000,
    once: true
});

// Counter Animation
const counterNums = document.querySelectorAll('.counter-num');

function animateCounter() {
    counterNums.forEach(counter => {
        const target = +counter.dataset.target;
        const count = +counter.innerText;
        const increment = target / 100;

        if (count < target) {
            counter.innerText = Math.ceil(count + increment);
            setTimeout(animateCounter, 50);
        } else {
            counter.innerText = target;
        }
    });
}

// Start animation when in view
const counterSection = document.querySelector('.counter');
const observer = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting) {
        animateCounter();
        observer.unobserve(counterSection);
    }
});

observer.observe(counterSection);

// Back to Top Button
const backToTopButton = document.querySelector('.back-to-top');

window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        backToTopButton.classList.add('active');
    } else {
        backToTopButton.classList.remove('active');
    }
});

backToTopButton.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// Smooth Scrolling for Navigation
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();

        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            window.scrollTo({
                top: target.offsetTop - 70,
                behavior: 'smooth'
            });
        }
    });
});

// Active Navigation Link
const sections = document.querySelectorAll('section[id]');

window.addEventListener('scroll', () => {
    let current = '';

    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;

        if (window.pageYOffset >= sectionTop - 150) {
            current = section.getAttribute('id');
        }
    });

    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) {
            link.classList.add('active');
        }
    });
});

// Language switching functionality
function toggleLanguage() {
    const htmlElement = document.documentElement;
    const langButton = document.querySelector('.lang-switch');

    if (htmlElement.getAttribute('lang') === 'ar') {
        // Switch to English
        htmlElement.setAttribute('lang', 'en');
        htmlElement.setAttribute('dir', 'ltr');
        langButton.textContent = 'العربية';

        // Load English content (this would typically fetch translations)
        translateToEnglish();
    } else {
        // Switch to Arabic
        htmlElement.setAttribute('lang', 'ar');
        htmlElement.setAttribute('dir', 'rtl');
        langButton.textContent = 'English';

        // Load Arabic content
        translateToArabic();
    }
}

// Sample translation functions (in a real app, you'd use a translation library or API)
function translateToEnglish() {
    // This is just a placeholder for actual translation logic
    console.log("Switching to English");
}

function translateToArabic() {
    // This is just a placeholder for actual translation logic
    console.log("Switching to Arabic");
}