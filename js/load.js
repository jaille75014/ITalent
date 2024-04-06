async function getMoreMails(){
    var mailCount = document.getElementById("mails").children.length;
    const response = await fetch("back/load_more_mails.php?mailCount=" + mailCount);
    const data = await response.text();
    document.getElementById("mails").innerHTML += data;
};