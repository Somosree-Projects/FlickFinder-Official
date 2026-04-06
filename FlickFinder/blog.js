// blog.js
document.addEventListener('DOMContentLoaded', function() {
    // Sample blog posts data
    const blogPosts = [
        {
            id: 1,
            title: "The Rise of Streaming Platforms",
            category: "industry",
            image: "https://via.placeholder.com/400x250",
            excerpt: "Exploring how streaming platforms are changing the entertainment landscape...",
            date: "December 30, 2024",
            author: "John Doe",
            comments: 10
        },
        // Add more sample posts here
    ];

    const popularPosts = [
        {
            title: "Top 10 Must-Watch Series of 2024",
            date: "December 25, 2024",
            image: "https://via.placeholder.com/100x100"
        },
        // Add more popular posts
    ];

    // Function to create post cards
    function createPostCard(post) {
        return `
            <article class="post-card">
                <img src="${post.image}" alt="${post.title}" class="post-image">
                <div class="post-content">
                    <span class="category">${post.category}</span>
                    <h3>${post.title}</h3>
                    <p class="meta">
                        <span><i class="fas fa-user"></i> ${post.author}</span>
                        <span><i class="fas fa-calendar"></i> ${post.date}</span>
                    </p>
                    <p>${post.excerpt}</p>
                    <a href="#" class="read-more">Read More</a>
                </div>
            </article>
        `;
    }

    // Function to load posts
    function loadPosts(category = 'all') {
        const postsContainer = document.querySelector('.posts-container');
        const filteredPosts = category === 'all' 
            ? blogPosts 
            : blogPosts.filter(post => post.category === category);
        
        postsContainer.innerHTML = filteredPosts.map(createPostCard).join('');
    }

    // Load popular posts
    function loadPopularPosts() {
        const popularList = document.querySelector('.popular-list');
        popularList.innerHTML = popularPosts.map(post => `
            <div class="popular-post">
                <img src="${post.image}" alt="${post.title}">
                <div class="popular-post-info">
                    <h4>${post.title}</h4>
                    <span>${post.date}</span>
                </div>
            </div>
        `).join('');
    }

    // Category filter functionality
    document.querySelectorAll('.category-btn').forEach(button => {
        button.addEventListener('click', () => {
            document.querySelector('.category-btn.active').classList.remove('active');
            button.classList.add('active');
            loadPosts(button.dataset.category);
        });
    });

    // Search functionality
    const searchInput = document.querySelector('.search-box input');
    searchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        const filteredPosts = blogPosts.filter(post => 
            post.title.toLowerCase().includes(searchTerm) ||
            post.excerpt.toLowerCase().includes(searchTerm)
        );
        const postsContainer = document.querySelector('.posts-container');
        postsContainer.innerHTML = filteredPosts.map(createPostCard).join('');
    });

    // Newsletter form submission
    document.getElementById('newsletter-form').addEventListener('submit', (e) => {
        e.preventDefault();
        const email = e.target.querySelector('input[type="email"]').value;
        // Handle newsletter subscription
        alert(`Thank you for subscribing with: ${email}`);
        e.target.reset();
    });

    // Initial load
    loadPosts();
    loadPopularPosts();
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
