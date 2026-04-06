document.querySelector('form').addEventListener('submit', function (e) {
    const name = document.querySelector('input[name="name"]').value;
    const email = document.querySelector('input[name="email"]').value;
    const password = document.querySelector('input[name="password"]').value;

    if (!name || !email || !password) {
        e.preventDefault();
        alert('Please fill in all fields.');
    }
});

