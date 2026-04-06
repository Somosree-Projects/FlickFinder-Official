// careers.js
document.addEventListener('DOMContentLoaded', function() {
    // Job listings data
    const jobListings = [
        {
            title: "Senior Software Engineer",
            department: "Engineering",
            location: "Remote",
            type: "Full-time",
            description: "Join our core engineering team to build and scale our streaming platform..."
        },
        // Add more job listings as needed
    ];

    // Filter jobs by department
    function filterJobs(department) {
        const filteredJobs = department === 'all' 
            ? jobListings 
            : jobListings.filter(job => job.department.toLowerCase() === department);
        displayJobs(filteredJobs);
    }

    // Display jobs in the grid
    function displayJobs(jobs) {
        const positionsGrid = document.querySelector('.positions-grid');
        positionsGrid.innerHTML = jobs.map(job => `
            <div class="position-card">
                <h3>${job.title}</h3>
                <p class="location"><i class="fas fa-map-marker-alt"></i> ${job.location}</p>
                <p class="department">${job.department}</p>
                <p class="type">${job.type}</p>
                <p class="description">${job.description}</p>
                <button class="apply-btn" onclick="applyForJob('${job.title}')">Apply Now</button>
            </div>
        `).join('');
    }

    // Apply for job function
    window.applyForJob = function(jobTitle) {
        // Show application modal
        const modal = document.getElementById('applicationModal');
        if (modal) {
            modal.style.display = 'block';
            document.getElementById('jobTitle').value = jobTitle;
        }
    };

    // Handle department filter clicks
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelector('.filter-btn.active').classList.remove('active');
            btn.classList.add('active');
            filterJobs(btn.dataset.department);
        });
    });

    // Handle application form submission
    const applicationForm = document.getElementById('applicationForm');
    if (applicationForm) {
        applicationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // Handle form submission
            alert('Application submitted successfully!');
            this.reset();
            document.getElementById('applicationModal').style.display = 'none';
        });
    }

    // Benefits section animation
    const benefitCards = document.querySelectorAll('.benefit-card');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
            }
        });
    }, { threshold: 0.5 });

    benefitCards.forEach(card => observer.observe(card));

    // Initial job listing display
    displayJobs(jobListings);
});
