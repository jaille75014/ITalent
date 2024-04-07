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