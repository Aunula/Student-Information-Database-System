const registerButton = document.getElementById('register');
const loginButton = document.getElementById('login');
const container = document.getElementById('container');

registerButton.onclick = function () {
    container.className = 'active';
};

loginButton.onclick = function () {
    container.className = 'close';
};

const loginForm = document.getElementById('login-form');
const registerForm = document.getElementById('register-form');
const loginMessage = document.getElementById('login-message');
const registerMessage = document.getElementById('register-message');

registerForm.addEventListener('submit', function (event) {
    event.preventDefault();

    const name = document.getElementById('register-name').value;
    const email = document.getElementById('register-email').value;
    const password = document.getElementById('register-password').value;

    fetch('register.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            name: name,
            email: email,
            password: password,
        }),
    })
    .then(response => response.json())
    .then(data => {
        registerMessage.textContent = data.message;
        if (data.success) {
            registerMessage.style.color = 'green';
            registerForm.reset();
            setTimeout(() => {
                 container.className = 'close';
            }, 2000);
        } else {
            registerMessage.style.color = 'red';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        registerMessage.textContent = 'An error occurred. Please try again.';
        registerMessage.style.color = 'red';
    });
});

loginForm.addEventListener('submit', function (event) {
    event.preventDefault(); 

    const email = document.getElementById('login-email').value;
    const password = document.getElementById('login-password').value;

    fetch('login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            email: email,
            password: password,
        }),
    })
    .then(response => response.json())
    .then(data => {
        loginMessage.textContent = data.message;
        if (data.success) {
            loginMessage.style.color = 'green';
            loginForm.reset();

            window.location.href = '../main/deshboard.html'; 
            
        } else {
            loginMessage.style.color = 'red';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        loginMessage.textContent = 'An error occurred. Please try again.';
        loginMessage.style.color = 'red';
    });
});