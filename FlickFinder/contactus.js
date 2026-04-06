// contactus.js
document.addEventListener('DOMContentLoaded', function() {
    // Initialize map
    function initMap() {
        // Replace with your actual coordinates
        const location = { lat: 37.7749, lng: -122.4194 };
        const mapOptions = {
            zoom: 15,
            center: location,
            styles: [
                // Add custom map styles here
                {
                    "elementType": "geometry",
                    "stylers": [{"color": "#242f3e"}]
                },
                {
                    "elementType": "labels.text.fill",
                    "stylers": [{"color": "#746855"}]
                }
                // Add more styles as needed
            ]
        };

        const map = new google.maps.Map(document.getElementById('map'), mapOptions);
        
        new google.maps.Marker({
            position: location,
            map: map,
            title: 'FlickFinder HQ'
        });
    }

    // Form validation and submission
    const contactForm = document.getElementById('contactForm');
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (validateForm()) {
            // Simulate form submission
            submitForm();
        }
    });

    function validateForm() {
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const subject = document.getElementById('subject').value;
        const message = document.getElementById('message').value;

        let isValid = true;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (name.trim() === '') {
            showError('name', 'Name is required');
            isValid = false;
        }

        if (!emailRegex.test(email)) {
            showError('email', 'Please enter a valid email');
            isValid = false;
        }

        if (subject === '') {
            showError('subject', 'Please select a subject');
            isValid = false;
        }

        if (message.trim() === '') {
            showError('message', 'Message is required');
            isValid = false;
        }

        return isValid;
    }

    function showError(fieldId, message) {
        const field = document.getElementById(fieldId);
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;
        
        // Remove any existing error message
        const existingError = field.parentElement.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }

        field.parentElement.appendChild(errorDiv);
        field.classList.add('error');

        // Remove error after 3 seconds
        setTimeout(() => {
            errorDiv.remove();
            field.classList.remove('error');
        }, 3000);
    }

    function submitForm() {
        // Simulate API call
        showLoadingState();
        
        setTimeout(() => {
            hideLoadingState();
            showSuccessModal();
            contactForm.reset();
        }, 2000);
    }

    function showLoadingState() {
        const submitBtn = contactForm.querySelector('.submit-btn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
    }

    function hideLoadingState() {
        const submitBtn = contactForm.querySelector('.submit-btn');
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Send Message';
    }

    function showSuccessModal() {
        const modal = document.getElementById('successModal');
        modal.style.display = 'flex';
    }

    // Close modal functionality
    const closeModal = document.querySelector('.close-modal');
    const modal = document.getElementById('successModal');

    closeModal.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Form field animations
    const formFields = document.querySelectorAll('.form-group input, .form-group textarea, .form-group select');
    formFields.forEach(field => {
        field.addEventListener('focus', () => {
            field.parentElement.classList.add('focused');
        });

        field.addEventListener('blur', () => {
            if (field.value === '') {
                field.parentElement.classList.remove('focused');
            }
        });
    });

    // Initialize map if Google Maps API is loaded
    if (typeof google !== 'undefined') {
        initMap();
    }
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
