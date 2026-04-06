// account.js
document.addEventListener('DOMContentLoaded', function() {
    // Tab Navigation
    const navButtons = document.querySelectorAll('.nav-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    navButtons.forEach(button => {
        button.addEventListener('click', () => {
            const tabName = button.dataset.tab;
            
            // Update active button
            navButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            // Show selected tab content
            tabContents.forEach(content => {
                content.classList.remove('active');
                if (content.id === tabName) {
                    content.classList.add('active');
                }
            });
        });
    });

    // Profile Form Submission
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // Simulate saving profile changes
            showSavingIndicator();
            setTimeout(() => {
                hideSavingIndicator();
                showSuccessMessage('Profile updated successfully!');
            }, 1500);
        });
    }

    // Profile Picture Upload
    const editPhotoBtn = document.querySelector('.edit-photo-btn');
    if (editPhotoBtn) {
        editPhotoBtn.addEventListener('click', function() {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.querySelector('.profile-image img').src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            };
            input.click();
        });
    }

    // Watchlist Management
    const watchlistData = [
        {
            title: "Movie Title 1",
            image: "https://via.placeholder.com/200x300",
            rating: "4.5"
        },
        // Add more watchlist items
    ];

    function loadWatchlist() {
        const watchlistGrid = document.querySelector('.watchlist-grid');
        if (watchlistGrid) {
            watchlistGrid.innerHTML = watchlistData.map(item => `
                <div class="watchlist-item">
                    <img src="${item.image}" alt="${item.title}">
                    <div class="item-info">
                        <h3>${item.title}</h3>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <span>${item.rating}</span>
                        </div>
                        <button class="remove-btn">Remove</button>
                    </div>
                </div>
            `).join('');
        }
    }

    // Password Change
    const changePasswordBtn = document.querySelector('.change-password-btn');
    const passwordModal = document.getElementById('passwordModal');
    const closeModal = document.querySelector('.close-modal');

    if (changePasswordBtn) {
        changePasswordBtn.addEventListener('click', () => {
            passwordModal.style.display = 'flex';
        });
    }

    if (closeModal) {
        closeModal.addEventListener('click', () => {
            passwordModal.style.display = 'none';
        });
    }

    const passwordForm = document.getElementById('passwordForm');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // Simulate password change
            showSavingIndicator();
            setTimeout(() => {
                hideSavingIndicator();
                passwordModal.style.display = 'none';
                showSuccessMessage('Password updated successfully!');
            }, 1500);
        });
    }

    // Utility Functions
    function showSavingIndicator() {
        const saveBtn = document.querySelector('.save-btn');
        if (saveBtn) {
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            saveBtn.disabled = true;
        }
    }

    function hideSavingIndicator() {
        const saveBtn = document.querySelector('.save-btn');
        if (saveBtn) {
            saveBtn.innerHTML = 'Save Changes';
            saveBtn.disabled = false;
        }
    }

    function showSuccessMessage(message) {
        const successDiv = document.createElement('div');
        successDiv.className = 'success-message';
        successDiv.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
        document.body.appendChild(successDiv);

        setTimeout(() => {
            successDiv.remove();
        }, 3000);
    }

    // Initial load
    loadWatchlist();
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
