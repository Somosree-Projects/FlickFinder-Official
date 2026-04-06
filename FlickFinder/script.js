// Constants and Configuration
const API_BASE_URL = 'https://api.flickfinder.com/v1';
const API_KEY = 'your_api_key_here';

// DOM Elements and Initialization
document.addEventListener('DOMContentLoaded', () => {
    // Initialize all components
    initializeForms();
    initializeSearch();
    initializeScrollToTop();
    initializeFeaturedCarousel(); // Added new carousel initialization
});

// New Featured Carousel Implementation
const initializeFeaturedCarousel = async () => {
    const featuredCarousel = document.querySelector('.featured-carousel');
    
    if (!featuredCarousel) return; // Guard clause if element doesn't exist
    
    try {
        const response = await fetch('get_recent_movies.php');
        const movies = await response.json();
        
        movies.forEach(movie => {
            const card = document.createElement('div');
            card.className = 'featured-card';
            card.innerHTML = `
                <img src="${movie.poster_path}" alt="${movie.title}">
                <div class="card-overlay">
                    <span class="${movie.badge_type.toLowerCase()}-badge">${movie.badge_type}</span>
                    <h3>${movie.title}</h3>
                    <div class="movie-info">
                        <span>${movie.release_year}</span>
                        <span>⭐ ${movie.imdb_rating}</span>
                    </div>
                </div>
            `;
            
            // Add click event to navigate to movie details
            card.addEventListener('click', () => {
                window.location.href = `movie_details.php?id=${movie.movie_id}`;
            });
            
            featuredCarousel.appendChild(card);
        });
    } catch (error) {
        console.error('Error loading featured movies:', error);
    }
};

// Form Validation and Handling
const initializeForms = () => {
    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');

    // Login Form Validation
    loginForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const email = loginForm.querySelector('input[name="email"]').value;
        const password = loginForm.querySelector('input[name="password"]').value;

        if (!validateEmail(email)) {
            showError('Please enter a valid email address');
            return;
        }

        if (password.length < 6) {
            showError('Password must be at least 6 characters long');
            return;
        }

        try {
            const response = await loginUser({ email, password });
            if (response.success) {
                showSuccess('Login successful!');
                closeModal('login');
            }
        } catch (error) {
            handleError(error);
        }
    });

    // Signup Form Validation
    signupForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const username = signupForm.querySelector('input[name="username"]').value;
        const email = signupForm.querySelector('input[name="email"]').value;
        const password = signupForm.querySelector('input[name="password"]').value;

        if (username.length < 3) {
            showError('Username must be at least 3 characters long');
            return;
        }

        if (!validateEmail(email)) {
            showError('Please enter a valid email address');
            return;
        }

        if (password.length < 6) {
            showError('Password must be at least 6 characters long');
            return;
        }

        try {
            const response = await registerUser({ username, email, password });
            if (response.success) {
                showSuccess('Registration successful!');
                closeModal('signup');
            }
        } catch (error) {
            handleError(error);
        }
    });
};

// Utility Functions
const validateEmail = (email) => {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
};

const showError = (message) => {
    createToast('error', message);
};

const showSuccess = (message) => {
    createToast('success', message);
};

const handleError = (error) => {
    console.error('Error:', error);
    showError(error.message || 'An unexpected error occurred');
};

// Toast Notification System
const createToast = (type, message) => {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
};

// Scroll to Top Functionality
const initializeScrollToTop = () => {
    const backToTopButton = document.getElementById('backToTopBtn');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            backToTopButton.style.display = 'block';
        } else {
            backToTopButton.style.display = 'none';
        }
    });

    backToTopButton?.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
};

// Search functionality
function openSearchModal() {
    document.getElementById('searchModal').style.display = 'block';
    document.getElementById('searchInput').focus();
}

function closeSearchModal() {
    document.getElementById('searchModal').style.display = 'none';
}

document.querySelector('.close-search').addEventListener('click', closeSearchModal);

// Close modal when clicking outside
window.addEventListener('click', (e) => {
    if (e.target === document.getElementById('searchModal')) {
        closeSearchModal();
    }
});

// Search functionality
function openSearchModal() {
    document.getElementById('searchModal').style.display = 'block';
    document.getElementById('searchInput').focus();
}

function closeSearchModal() {
    document.getElementById('searchModal').style.display = 'none';
}

// Add event listeners when the document is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Close button event listener
    document.querySelector('.close-search').addEventListener('click', closeSearchModal);

    // Close modal when clicking outside
    window.addEventListener('click', (e) => {
        if (e.target === document.getElementById('searchModal')) {
            closeSearchModal();
        }
    });

    // Search input handler with debouncing
    let searchTimeout;
    document.getElementById('searchInput').addEventListener('input', (e) => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const searchTerm = e.target.value.trim();
            if (searchTerm.length >= 2) {
                performSearch(searchTerm);
            }
        }, 300);
    });
});

function performSearch(searchTerm) {
    console.log('Searching for:', searchTerm); // Debug log

    fetch(`search.php?q=${encodeURIComponent(searchTerm)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Search results:', data); // Debug log
            if (data.error) {
                console.error('Server error:', data.error);
                displayError(data.error);
            } else {
                displaySearchResults(data.results);
            }
        })
        .catch(error => {
            console.error('Search error:', error);
            displayError('An error occurred while searching');
        });
}

function displaySearchResults(results) {
    const resultsContainer = document.getElementById('searchResults');
    resultsContainer.innerHTML = '';

    if (results.length === 0) {
        resultsContainer.innerHTML = '<div class="search-error">No results found</div>';
        return;
    }

    results.forEach(movie => {
        const resultItem = document.createElement('div');
        resultItem.className = 'search-result-item';
        resultItem.innerHTML = `
            <img src="${movie.poster_path}" alt="${movie.title}" class="result-poster">
            <div class="result-info">
                <h3 class="result-title">${movie.title} (${movie.release_year})</h3>
                <div class="result-rating">⭐ ${movie.imdb_rating}</div>
            </div>
        `;
        resultItem.addEventListener('click', () => {
            window.location.href = `details.php?id=${movie.movie_id}`;
        });
        resultsContainer.appendChild(resultItem);
    });
}

function displayError(message) {
    const resultsContainer = document.getElementById('searchResults');
    resultsContainer.innerHTML = `<div class="search-error">${message}</div>`;
}


