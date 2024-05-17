document.addEventListener('DOMContentLoaded', (event) => {
    const container = document.getElementById('container');
    const registerBtn = document.getElementById('register');
    const loginBtn = document.getElementById('login');


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

function openVerificationNewsletter(event) {
    // Empêcher l'envoi normal du formulaire
    event.preventDefault();

    // Obtenir le formulaire et son action
    let form = event.target;
    let url = form.action;

    // Créer un objet pour stocker les données du formulaire
    let data = {};

    // Pour chaque élément du formulaire...
    for (let element of form.elements) {
        // Si l'élément a un nom, ajoutez-le aux données
        if (element.name) {
            data[element.name] = element.value;
        }
    }

    // Créer un nouveau formulaire dynamiquement
    let dynamicForm = document.createElement('form');
    dynamicForm.method = 'POST';
    dynamicForm.action = url;
    dynamicForm.target = '_blank';

    // Ajouter les données au formulaire dynamique
    for (let key in data) {
        let input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = data[key];
        dynamicForm.appendChild(input);
    }

    // Ajouter le formulaire dynamique au corps du document et le soumettre
    document.body.appendChild(dynamicForm);
    dynamicForm.submit();

    // Supprimer le formulaire dynamique du corps du document
    document.body.removeChild(dynamicForm);
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

const inputs = document.querySelectorAll(".input");

function focusFunc() {
  let parent = this.parentNode;
  parent.classList.add("focus");
}

function blurFunc() {
  let parent = this.parentNode;
  if (this.value == "") {
    parent.classList.remove("focus");
  }
}

inputs.forEach((input) => {
  input.addEventListener("focus", focusFunc);
  input.addEventListener("blur", blurFunc);
});
