// Cookiespreferences.js
document.addEventListener('DOMContentLoaded', function() {
    // Load saved preferences
    loadPreferences();

    // Save preferences button
    const saveBtn = document.getElementById('savePreferences');
    saveBtn.addEventListener('click', savePreferences);

    // Accept all button
    const acceptAllBtn = document.getElementById('acceptAll');
    acceptAllBtn.addEventListener('click', acceptAllCookies);

    // Modal close button
    const closeBtn = document.querySelector('.close-btn');
    closeBtn.addEventListener('click', closeModal);

    // Cookie toggle switches
    const cookieToggles = document.querySelectorAll('.switch input[type="checkbox"]');
    cookieToggles.forEach(toggle => {
        toggle.addEventListener('change', updatePreferencesState);
    });

    function loadPreferences() {
        const savedPreferences = JSON.parse(localStorage.getItem('cookiePreferences')) || {
            performance: false,
            functional: false,
            marketing: false
        };

        document.getElementById('performanceCookies').checked = savedPreferences.performance;
        document.getElementById('functionalCookies').checked = savedPreferences.functional;
        document.getElementById('marketingCookies').checked = savedPreferences.marketing;
    }

    function savePreferences() {
        const preferences = {
            performance: document.getElementById('performanceCookies').checked,
            functional: document.getElementById('functionalCookies').checked,
            marketing: document.getElementById('marketingCookies').checked
        };

        localStorage.setItem('cookiePreferences', JSON.stringify(preferences));
        localStorage.setItem('cookiePreferencesTimestamp', new Date().toISOString());

        // Apply preferences
        applyPreferences(preferences);

        // Show success modal
        showModal();
    }

    function acceptAllCookies() {
        const preferences = {
            performance: true,
            functional: true,
            marketing: true
        };

        // Update toggles
        document.getElementById('performanceCookies').checked = true;
        document.getElementById('functionalCookies').checked = true;
        document.getElementById('marketingCookies').checked = true;

        localStorage.setItem('cookiePreferences', JSON.stringify(preferences));
        localStorage.setItem('cookiePreferencesTimestamp', new Date().toISOString());

        // Apply preferences
        applyPreferences(preferences);

        // Show success modal
        showModal();
    }

    function applyPreferences(preferences) {
        // Performance cookies
        if (preferences.performance) {
            enableAnalytics();
        } else {
            disableAnalytics();
        }

        // Functional cookies
        if (preferences.functional) {
            enableFunctionalCookies();
        } else {
            disableFunctionalCookies();
        }

        // Marketing cookies
        if (preferences.marketing) {
            enableMarketingCookies();
        } else {
            disableMarketingCookies();
        }
    }

    function enableAnalytics() {
        // Implementation for enabling analytics
        console.log('Analytics enabled');
    }

    function disableAnalytics() {
        // Implementation for disabling analytics
        console.log('Analytics disabled');
    }

    function enableFunctionalCookies() {
        // Implementation for enabling functional cookies
        console.log('Functional cookies enabled');
    }

    function disableFunctionalCookies() {
        // Implementation for disabling functional cookies
        console.log('Functional cookies disabled');
    }

    function enableMarketingCookies() {
        // Implementation for enabling marketing cookies
        console.log('Marketing cookies enabled');
    }

    function disableMarketingCookies() {
        // Implementation for disabling marketing cookies
        console.log('Marketing cookies disabled');
    }

    function updatePreferencesState() {
        const hasChanges = checkForChanges();
        saveBtn.disabled = !hasChanges;
        saveBtn.style.opacity = hasChanges ? '1' : '0.5';
    }

    function checkForChanges() {
        const savedPreferences = JSON.parse(localStorage.getItem('cookiePreferences')) || {
            performance: false,
            functional: false,
            marketing: false
        };

        return (
            savedPreferences.performance !== document.getElementById('performanceCookies').checked ||
            savedPreferences.functional !== document.getElementById('functionalCookies').checked ||
            savedPreferences.marketing !== document.getElementById('marketingCookies').checked
        );
    }

    function showModal() {
        const modal = document.getElementById('preferencesModal');
        modal.style.display = 'flex';
    }

    function closeModal() {
        const modal = document.getElementById('preferencesModal');
        modal.style.display = 'none';
    }

    // Close modal when clicking outside
    window.addEventListener('click', (e) => {
        const modal = document.getElementById('preferencesModal');
        if (e.target === modal) {
            closeModal();
        }
    });

    // Check if preferences need to be updated (older than 90 days)
    function checkPreferencesAge() {
        const timestamp = localStorage.getItem('cookiePreferencesTimestamp');
        if (timestamp) {
            const preferencesDate = new Date(timestamp);
            const currentDate = new Date();
            const daysSinceSet = (currentDate - preferencesDate) / (1000 * 60 * 60 * 24);

            if (daysSinceSet > 90) {
                showPreferencesPrompt();
            }
        }
    }

    function showPreferencesPrompt() {
        const prompt = document.createElement('div');
        prompt.className = 'preferences-prompt';
        prompt.innerHTML = `
            <p>Your cookie preferences were set more than 90 days ago. Would you like to review them?</p>
            <button onclick="this.parentElement.remove()">Review Preferences</button>
        `;
        document.body.appendChild(prompt);
    }

    // Initialize
    checkPreferencesAge();
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
