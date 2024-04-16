const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

console.log("Hello");

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});


// Pop Up Index.php
function openForm() {
    document.getElementById("popupForm").style.display = "block";
}

function closeForm() {
document.getElementById("popupForm").style.display = "none";
}

function openForm2() {
    document.getElementById("popupForm2").style.display = "block";
}

function closeForm2() {
document.getElementById("popupForm2").style.display = "none";
}


function togglePasswordVisibility(eye) {
    const passwordInput = eye.previousElementSibling;
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eye.src = "assets/eye.svg"; // Change the image when password is visible
    } else {
        passwordInput.type = "password";
        eye.src = "assets/eye-slash.svg"; // Change the image when password is hidden
    }
}

async function follow(button) {
    const followed = button.parentElement.querySelector('.user_followed').value;
    const follower = button.parentElement.querySelector('.user_follower').value;
    const res = await fetch(`back/connect_users.php?followed=${followed}&follower=${follower}`);
    const txt = await res.text();
    const icon = button.querySelector('i');
    icon.classList.toggle("bi-person-plus");
    icon.classList.toggle("bi-person-check-fill");
}