const registerButton = document.getElementById('register');
const loginButton = document.getElementById('login');
const container = document.getElementById('container');

// ফ্লিপ অ্যানিমেশনের জন্য কোড
registerButton.onclick = function () {
    container.className = 'active';
};

loginButton.onclick = function () {
    container.className = 'close';
};

// --- ডেটাবেস কানেকশনের জন্য কোড ---

// ফর্ম এলিমেন্ট এবং মেসেজ স্প্যান সিলেক্ট করা (HTML-এ এই id গুলো থাকতে হবে)
const loginForm = document.getElementById('login-form');
const registerForm = document.getElementById('register-form');
const loginMessage = document.getElementById('login-message');
const registerMessage = document.getElementById('register-message');

// রেজিস্ট্রেশন ফর্ম সাবমিট হ্যান্ডলার
registerForm.addEventListener('submit', function (event) {
    event.preventDefault(); // ফর্মের ডিফল্ট সাবমিট বন্ধ করা

    // ইনপুট ভ্যালুগুলো নেওয়া
    const name = document.getElementById('register-name').value;
    const email = document.getElementById('register-email').value;
    const password = document.getElementById('register-password').value;

    // সার্ভারে ডেটা পাঠানো (Fetch API ব্যবহার করে register.php-কে call করা)
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
        // সার্ভার থেকে আসা রেসপন্স দেখানো
        registerMessage.textContent = data.message;
        if (data.success) {
            registerMessage.style.color = 'green';
            // সফল হলে ফর্ম রিসেট করা
            registerForm.reset();
            // ২ সেকেন্ড পর লগইন প্যানেলে ফ্লিপ করানো
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

// লগইন ফর্ম সাবমিট হ্যান্ডলার
loginForm.addEventListener('submit', function (event) {
    event.preventDefault(); // ফর্মের ডিফল্ট সাবমিট বন্ধ করা

    // ইনপুট ভ্যালুগুলো নেওয়া
    const email = document.getElementById('login-email').value;
    const password = document.getElementById('login-password').value;

    // সার্ভারে ডেটা পাঠানো (Fetch API ব্যবহার করে login.php-কে call করা)
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
        // সার্ভার থেকে আসা রেসপন্স দেখানো
        loginMessage.textContent = data.message;
        if (data.success) {
            loginMessage.style.color = 'green';
            loginForm.reset();
            
            // !!!!!!!!!! সফল রিডাইরেক্ট কোড !!!!!!!!!!
            // login ফোল্ডার থেকে এক ধাপ বাইরে (../) গিয়ে main ফোল্ডারে (main/) ঢুকে deshboard.html-কে লোড করবে।
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