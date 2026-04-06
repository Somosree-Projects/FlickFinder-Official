// TermsofService.js
document.addEventListener('DOMContentLoaded', function() {
    // Navigation functionality
    const navItems = document.querySelectorAll('.nav-item');
    const contentSections = document.querySelectorAll('.content-section');

    navItems.forEach(item => {
        item.addEventListener('click', () => {
            const sectionId = item.dataset.section;
            
            // Update active nav item
            navItems.forEach(nav => nav.classList.remove('active'));
            item.classList.add('active');

            // Show selected content section
            contentSections.forEach(section => {
                section.classList.remove('active');
                if (section.id === sectionId) {
                    section.classList.add('active');
                }
            });

            // Smooth scroll to section
            document.getElementById(sectionId).scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        });
    });

    // Terms acceptance functionality
    const acceptBtn = document.getElementById('acceptTerms');
    const declineBtn = document.getElementById('declineTerms');

    acceptBtn.addEventListener('click', () => {
        localStorage.setItem('termsAccepted', 'true');
        localStorage.setItem('termsAcceptedDate', new Date().toISOString());
        showToast('Terms of Service accepted');
    });

    declineBtn.addEventListener('click', () => {
        if (confirm('You must accept the Terms of Service to use FlickFinder. Do you want to decline anyway?')) {
            window.location.href = 'index.html';
        }
    });

    // Scroll spy for navigation
    window.addEventListener('scroll', () => {
        const scrollPosition = window.scrollY;

        contentSections.forEach(section => {
            const sectionTop = section.offsetTop - 100;
            const sectionBottom = sectionTop + section.offsetHeight;

            if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
                navItems.forEach(item => {
                    item.classList.remove('active');
                    if (item.dataset.section === section.id) {
                        item.classList.add('active');
                    }
                });
            }
        });
    });

    // Print functionality
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'p') {
            e.preventDefault();
            preparePrint();
        }
    });

    function preparePrint() {
        // Add print date
        const printNotice = document.querySelector('.print-notice');
        const date = new Date().toLocaleDateString();
        printNotice.querySelector('p:last-child').textContent = `Date: ${date}`;
        
        window.print();
    }

    // Copy link functionality
    function copyLink() {
        const currentURL = window.location.href;
        navigator.clipboard.writeText(currentURL).then(() => {
            showToast('Link copied to clipboard!');
        }).catch(err => {
            console.error('Failed to copy link:', err);
        });
    }

    // Toast notification
    function showToast(message) {
        const toast = document.createElement('div');
        toast.className = 'toast-message';
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    // Check terms acceptance status
    function checkTermsAcceptance() {
        const termsAccepted = localStorage.getItem('termsAccepted');
        const acceptedDate = localStorage.getItem('termsAcceptedDate');

        if (termsAccepted && acceptedDate) {
            const acceptanceDate = new Date(acceptedDate);
            const currentDate = new Date();
            const daysSinceAcceptance = (currentDate - acceptanceDate) / (1000 * 60 * 60 * 24);

            // If terms were accepted more than 90 days ago, prompt for re-acceptance
            if (daysSinceAcceptance > 90) {
                localStorage.removeItem('termsAccepted');
                localStorage.removeItem('termsAcceptedDate');
                showToast('Please review and accept the updated Terms of Service');
            }
        }
    }

    // Initialize
    checkTermsAcceptance();
});

// Back to top functionality
window.addEventListener('scroll', () => {
    const backToTopBtn = document.getElementById('backToTopBtn');
    if (window.scrollY > 300) {
        backToTopBtn.style.display = 'block';
    } else {
        backToTopBtn.style.display = 'none';
    }
});

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}
