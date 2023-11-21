const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');
const errors = document.querySelector('.errors');
registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

// Set opacity to 0 after a delay
errors.style.transition = 'opacity 0.5s ease-out';
setTimeout(() => {
    errors.style.opacity = '0';
}, 3000);
setTimeout(() => {
    errors.style.display = 'none';
}, 3200);
