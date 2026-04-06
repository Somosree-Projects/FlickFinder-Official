// FAQ.js
document.addEventListener('DOMContentLoaded', function() {
    // FAQ Data
    const faqData = {
        account: [
            {
                question: "How do I create an account?",
                answer: "To create an account, click the 'Sign Up' button in the top right corner and follow the registration process. You'll need to provide your email address and create a password."
            },
            {
                question: "How do I change my password?",
                answer: "You can change your password by going to Account Settings > Security > Change Password. You'll need to enter your current password and then create a new one."
            }
        ],
        streaming: [
            {
                question: "What devices can I watch on?",
                answer: "FlickFinder is available on most devices including smartphones, tablets, smart TVs, gaming consoles, and web browsers."
            },
            {
                question: "Can I download content to watch offline?",
                answer: "Yes, most content is available for download on our mobile apps. Look for the download icon next to the title."
            }
        ],
        content: [
            {
                question: "How often is new content added?",
                answer: "We add new movies and TV shows weekly. New releases are typically added on Fridays."
            },
            {
                question: "Can I request specific content?",
                answer: "Yes, you can submit content requests through our Help Center. While we can't guarantee all requests, we do consider user feedback."
            }
        ],
        technical: [
            {
                question: "What internet speed do I need?",
                answer: "We recommend at least 5 Mbps for HD streaming and 25 Mbps for 4K content."
            },
            {
                question: "Why am I experiencing buffering?",
                answer: "Buffering can be caused by slow internet connection, network congestion, or device issues. Try our connection test tool for specific recommendations."
            }
        ]
    };

    // Load FAQs
    function loadFAQs(category = 'all') {
        const faqList = document.querySelector('.faq-list');
        let faqs = [];

        if (category === 'all') {
            Object.values(faqData).forEach(categoryFaqs => {
                faqs = faqs.concat(categoryFaqs);
            });
        } else {
            faqs = faqData[category] || [];
        }

        faqList.innerHTML = faqs.map((faq, index) => `
            <div class="faq-item" data-index="${index}">
                <div class="faq-question">
                    <h3>${faq.question}</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>${faq.answer}</p>
                </div>
            </div>
        `).join('');

        // Add click handlers to new FAQ items
        addFAQHandlers();
    }

    // Add click handlers to FAQ items
    function addFAQHandlers() {
        document.querySelectorAll('.faq-item').forEach(item => {
            item.querySelector('.faq-question').addEventListener('click', () => {
                const wasActive = item.classList.contains('active');
                // Close all other items
                document.querySelectorAll('.faq-item').forEach(otherItem => {
                    otherItem.classList.remove('active');
                });
                // Toggle clicked item
                item.classList.toggle('active', !wasActive);
            });
        });
    }

    // Search functionality
    const searchInput = document.getElementById('faqSearch');
    searchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        const allFaqs = [];
        
        Object.values(faqData).forEach(categoryFaqs => {
            categoryFaqs.forEach(faq => {
                if (faq.question.toLowerCase().includes(searchTerm) ||
                    faq.answer.toLowerCase().includes(searchTerm)) {
                    allFaqs.push(faq);
                }
            });
        });

        const faqList = document.querySelector('.faq-list');
        faqList.innerHTML = allFaqs.map((faq, index) => `
            <div class="faq-item" data-index="${index}">
                <div class="faq-question">
                    <h3>${faq.question}</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>${faq.answer}</p>
                </div>
            </div>
        `).join('');

        addFAQHandlers();
    });

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
    const liveChatBtn = document.getElementById('liveChatBtn');
    const closeModal = document.querySelector('.close-modal');

    liveChatBtn.addEventListener('click', (e) => {
        e.preventDefault();
        chatModal.style.display = 'block';
        initializeChat();
    });

    closeModal.addEventListener('click', () => {
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
    loadFAQs();
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
