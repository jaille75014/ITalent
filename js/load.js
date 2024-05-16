async function getMoreMails(){
    var mailCount = document.getElementById("mails").children.length;
    const response = await fetch("back/load_more_mails.php?mailCount=" + mailCount);
    const data = await response.text();
    document.getElementById("mails").innerHTML += data;
}

async function searchID(){
    const input = document.getElementById('user_id');
    const id = input.value;
    const res = await fetch('back/search_users.php?name=' + id);
    const txt = await res.text();
    const table = document.getElementById("users");
    table.innerHTML = txt;
}

async function search(queryParam, inputId){
    const input = document.getElementById(inputId);
    const value = input.value;
    const res = await fetch(`back/search_users.php?${queryParam}=${value}`);
    const txt = await res.text();
    const table = document.getElementById("users");
    table.innerHTML = txt;
}


 async function addQuestionsToCompetence(){
    const competence = document.getElementById('selectCompetence');
    const question = document.getElementById('question');
    const answer1 = document.getElementById('answer1');
    const answer2 = document.getElementById('answer2');
    const answer3 = document.getElementById('answer3');
    const answer4 = document.getElementById('answer4');
    const answerCorrect = document.getElementById('answerCorrect');

    const res = await fetch(`back/addQuestionsCompetence?competence=${competence.value}&question=${question.value}&answer1=${answer1.value}&answer2=${answer2.value}&answer3=${answer3.value}&answer4=${answer4.value}&answerCorrect=${answerCorrect.value}`);
    const txt = await res.text();

    competence.value="Sélectionner une compétence";
    question.value="";
    answer1.value="";
    answer2.value="";
    answer3.value="";
    answer4.value="";
    answerCorrect.value="";

    if(txt==1) {
        document.getElementById('result').innerHTML='<div class="alert alert-success" role="alert">Votre question a bien été ajoutée.</div>';
    }else{ 
        document.getElementById('result').innerHTML='<div class="alert alert-danger" role="alert">Vous devez remplir l\'ensemble des champs.</div>';
    }


    selectCompetence();

}

async function selectCompetence(){
    const competence=document.getElementById("selectCompetence2");
    const div = document.getElementById("tableQuestions");

    const res = await fetch(`back/seeTableQuestionsCompetence.php?competence=${competence.value}`);
    const txt = await res.text();

    

    const tableauQuestions = JSON.parse(txt);
    if (tableauQuestions.length!=0){
        let html = '<table class="table table-striped my-5 align-middle"><thead><tr><th>Question</th><th>Réponse 1</th><th>Réponse 2</th><th>Réponse 3</th><th>Réponse 4</th><th>Bonne réponse</th><th>Suppression</th><th>Modification</th></tr></thead><tbody>';
        for(let i=0;i<tableauQuestions.length;++i){
            const question = tableauQuestions[i];
            html+="<tr>";
            html+='<td>'+question['question']+'</td>';
            html+='<td>'+question['answer1']+'</td>';
            html+='<td>'+question['answer2']+'</td>';
            html+='<td>'+question['answer3']+'</td>';
            html+='<td>'+question['answer4']+'</td>';
            html+='<td>'+question['answerCorrect']+'</td>';
            html+='<td><button class="btn btn-danger" onclick="suppQuestions(\''+question['question']+'\')">Supprimer</button></td>'; 
            html+='<td> <form action="modifQuestionsCompetence" method="post">' ;
            html+='<input type="hidden" value="'+question['question']+'" name="question"> <button class="btn btn-success" type="submit" >Modifier</button>';
            html+='  </form> </td>';      
            html+="</tr>";
        }
        html+="</tbody></table>";

        
        div.innerHTML=html;
        console.log(div.innerHTML);

    } else {
        div.innerHTML='';
    }

}

async function suppQuestions(question){
    const res = await fetch(`back/deleteQuestionsCompetence.php?question=${question}`);
    
    selectCompetence();
    
}
// notifications.js
if("Notification" in window){
    // Check permissions
    if(Notification.permission === "granted"){
        checkForNewMessages();
    } else{
        Notification.requestPermission().then((res) =>{
            if(res === "granted"){
                checkForNewMessages();
            } else if(res === "denied"){
                console.log("Notifications access denied"); 
            } else if(res === "default"){
                console.log("Notifiations permission closed"); 
            }
        });
    }       
} else { 
    console.log("Notifications not supported");
}

function checkForNewMessages() {
    fetch('back/is_new_messages.php?' + new Date().getTime())
        .then(response => response.json())
        .then(data => {
            if (data > 0) {
                notify();
            }
        })
        .catch(error => console.error('Error:', error));
}

function notify() {
    const notification = new Notification("Nouveaux messages", {
        body: "Vous avez reçu de nouveaux messages. Cliquez ici pour les consulter.",
        icon: "../assets/LOGO_version_minimalisé.png",
        vibrate: [200, 100, 200],
    });

    notification.addEventListener("click", () => {
        window.open('https://italent.site/messagerie');
    });

    setTimeout(() => {
        notification.close();
    }, 7000)
}


async function addPubliRefresh() {
    const form = document.getElementById("ajouterPublicationForm");
    const formData = new FormData(form);

    try {
        const response = await fetch("back/ajouter_publication", {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error('Une erreur s\'est produite lors de la requête.');
        }

        // Recharge la page si la requête est réussie
        window.location.reload();
    } catch (error) {
        console.error('Erreur:', error);
        // Gérer l'erreur ici, par exemple, afficher un message d'erreur à l'utilisateur
    }
}