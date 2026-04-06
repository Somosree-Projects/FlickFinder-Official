// press.js
document.addEventListener('DOMContentLoaded', function() {
    // Press releases data
    const pressReleases = [
        {
            title: "FlickFinder Announces Global Expansion",
            date: "December 30, 2024",
            category: "Company News",
            excerpt: "FlickFinder expands its streaming service to 50 new countries...",
            image: "https://via.placeholder.com/400x250"
        },
        // Add more press releases
    ];

    // Load press releases
    function loadPressReleases(category = 'all') {
        const newsGrid = document.querySelector('.news-grid');
        const filteredReleases = category === 'all' 
            ? pressReleases 
            : pressReleases.filter(release => release.category === category);
        
        newsGrid.innerHTML = filteredReleases.map(release => `
            <article class="news-card">
                <div class="news-image">
                    <img src="${release.image}" alt="${release.title}">
                    <span class="date-badge">${release.date}</span>
                </div>
                <div class="news-content">
                    <h3>${release.title}</h3>
                    <p>${release.excerpt}</p>
                    <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                </div>
            </article>
        `).join('');
    }

    // Press kit download functionality
    function handleDownload(resourceType) {
        // Simulate download process
        const downloadMap = {
            'brand-assets': 'FlickFinder_Brand_Assets.zip',
            'fact-sheet': 'FlickFinder_Fact_Sheet.pdf',
            'media-gallery': 'FlickFinder_Media_Gallery.zip'
        };

        alert(`Downloading ${downloadMap[resourceType]}`);
    }

    // Add download handlers
    document.querySelectorAll('.download-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            handleDownload(this.dataset.resource);
        });
    });

    // Media contact form handling
    const contactForm = document.getElementById('media-contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // Handle form submission
            alert('Your media inquiry has been submitted. We will contact you shortly.');
            this.reset();
        });
    }

    // Search functionality
    const searchInput = document.querySelector('.press-search input');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const filteredReleases = pressReleases.filter(release => 
                release.title.toLowerCase().includes(searchTerm) ||
                release.excerpt.toLowerCase().includes(searchTerm)
            );
            loadPressReleases('all', filteredReleases);
        });
    }

    // Animation for press kit items
    const kitItems = document.querySelectorAll('.kit-item');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
            }
        });
    }, { threshold: 0.5 });

    kitItems.forEach(item => observer.observe(item));

    // Initial load
    loadPressReleases();
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
