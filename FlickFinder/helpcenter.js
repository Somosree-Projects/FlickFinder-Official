// helpcenter.js
document.addEventListener('DOMContentLoaded', function() {
    // FAQ Data
    const faqs = {
        general: [
            {
                question: "What is FlickFinder?",
                answer: "FlickFinder is a streaming platform that offers movies, TV shows, and exclusive content..."
            },
            {
                question: "How do I create an account?",
                answer: "You can create an account by clicking the 'Sign Up' button and following the registration process..."
            }
        ],
        technical: [
            {
                question: "What devices are supported?",
                answer: "FlickFinder is available on web browsers, mobile devices, smart TVs, and gaming consoles..."
            }
        ],
        billing: [
            {
                question: "What payment methods are accepted?",
                answer: "We accept major credit cards, PayPal, and various local payment methods..."
            }
        ],
        content: [
            {
                question: "How often is new content added?",
                answer: "We add new content weekly, including movies, TV shows, and FlickFinder originals..."
            }
        ]
    };

    // Load FAQs based on category
    function loadFAQs(category) {
        const faqContainer = document.querySelector('.faq-container');
        const categoryFaqs = faqs[category];
        
        faqContainer.innerHTML = categoryFaqs.map((faq, index) => `
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(${index})">
                    <span>${faq.question}</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>${faq.answer}</p>
                </div>
            </div>
        `).join('');
    }

    // Toggle FAQ answer
    window.toggleFAQ = function(index) {
        const faqItems = document.querySelectorAll('.faq-item');
        faqItems[index].classList.toggle('active');
    };

    // Search functionality
    const searchInput = document.querySelector('.search-box input');
    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const allFaqs = [];
        
        // Combine all FAQs for searching
        Object.values(faqs).forEach(category => {
            category.forEach(faq => allFaqs.push(faq));
        });

        const searchResults = allFaqs.filter(faq => 
            faq.question.toLowerCase().includes(searchTerm) ||
            faq.answer.toLowerCase().includes(searchTerm)
        );

        displaySearchResults(searchResults);
    });

    function displaySearchResults(results) {
        const faqContainer = document.querySelector('.faq-container');
        faqContainer.innerHTML = results.map((faq, index) => `
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(${index})">
                    <span>${faq.question}</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>${faq.answer}</p>
                </div>
            </div>
        `).join('');
    }

    // Category filter functionality
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelector('.category-btn.active').classList.remove('active');
            btn.classList.add('active');
            loadFAQs(btn.dataset.category);
        });
    });

    // Live Chat functionality
    const chatModal = document.getElementById('chatModal');
    document.querySelectorAll('.support-btn').forEach(btn => {
        if(btn.parentElement.querySelector('h3').textContent === 'Live Chat') {
            btn.addEventListener('click', () => {
                chatModal.style.display = 'block';
                initializeChat();
            });
        }
    });

    // Close chat modal
    document.querySelector('.close-modal').addEventListener('click', () => {
        chatModal.style.display = 'none';
    });

    function initializeChat() {
        const chatMessages = document.querySelector('.chat-messages');
        chatMessages.innerHTML = `
            <div class="chat-message support">
                <p>Hello! How can I help you today?</p>
            </div>
        `;
    }

    // Handle chat input
    const chatInput = document.querySelector('.chat-input input');
    const chatButton = document.querySelector('.chat-input button');

    function sendMessage() {
        const message = chatInput.value.trim();
        if(message) {
            const chatMessages = document.querySelector('.chat-messages');
            chatMessages.innerHTML += `
                <div class="chat-message user">
                    <p>${message}</p>
                </div>
            `;
            chatInput.value = '';
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }

    chatButton.addEventListener('click', sendMessage);
    chatInput.addEventListener('keypress', (e) => {
        if(e.key === 'Enter') sendMessage();
    });

    // Initial load
    loadFAQs('general');
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
