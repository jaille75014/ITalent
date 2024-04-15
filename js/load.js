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
    console.log("yah");
    const competence = document.getElementById('selectCompetence');
    const question = document.getElementById('question');
    const answer1 = document.getElementById('answer1');
    const answer2 = document.getElementById('answer2');
    const answer3 = document.getElementById('answer3');
    const answer4 = document.getElementById('answer4');
    const answerCorrect = document.getElementById('answerCorrect');

    const res = await fetch(`back/addQuestionsCompetence.php?competence=${competence.value}&question=${question.value}&answer1=${answer1.value}&answer2=${answer2.value}&answer3=${answer3.value}&answer4=${answer4.value}&answerCorrect=${answerCorrect.value}`);
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




}

function selectCompetence(){
    console.log("test");
}