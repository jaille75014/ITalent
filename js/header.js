const toggler = document.getElementById("toggler");
const nav = document.getElementById("nav");

toggler.addEventListener("click",toggleNav);

function toggleNav(){
    toggler.classList.toggle("active");
    nav.classList.toggle("active");
}
