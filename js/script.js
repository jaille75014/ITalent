document.addEventListener('DOMContentLoaded', (event) => {
    const container = document.getElementById('container');
    const registerBtn = document.getElementById('register');
    const loginBtn = document.getElementById('login');

    console.log("Hello");

    if(registerBtn) {
        registerBtn.addEventListener('click', () => {
            container.classList.add("active");
        });
    }

    if(loginBtn) {
        loginBtn.addEventListener('click', () => {
            container.classList.remove("active");
        });
    }
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
    console.log(button);
    const followedElement = button.parentElement.querySelector('.user_followed');
    const followerElement = button.parentElement.querySelector('.user_follower');
    if (!followedElement || !followerElement) {
        console.error('Les elements n\'ont pas été trouvés');
        return;
    }
    const followed = followedElement.value;
    const follower = followerElement.value;
    console.log(followed, follower);
    const res = await fetch(`back/connect_users.php?followed=${followed}&follower=${follower}`);
    const txt = await res.text();
    console.log(res, txt);
    const icon = button.querySelector('i');
    console.log(icon);
    icon.classList.toggle("bi-person-plus");
    icon.classList.toggle("bi-person-check-fill");
}

// Open the page newsletter with windows.open
async function openVerificationNewsletter(event) {
    event.preventDefault(); // N'envoie pas le formulaire normalement
    var form = document.getElementById('newsletterForm'); 
    var url = form.action; // Récupère l'URL du formulaire 
    var formData = new FormData(form); // Crée un objet FormData avec les données du formulaire

    const response = await fetch(url, {
        method: 'POST',
        body: formData
    });

    if (response.ok) { // Si le serveur a répondu avec un code 200
        // get the response body
        const json = await response.json();
    } else {
        alert("HTTP-Error: " + response.status);
    }

    window.open(url, '_blank');
}

// vérifier que les mots de passe correspondent | page profil.php
document.querySelector('form').addEventListener('submit', function(event) {
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm_password').value;

    if (password !== confirmPassword) {
        alert('Les mots de passe ne correspondent pas.');
        event.preventDefault(); // Empêche l'envoi du formulaire
    }
});