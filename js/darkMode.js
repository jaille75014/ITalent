button = document.getElementById("darkMode");
let theme= localStorage.getItem('theme') || 'light';

const date = new Date() ;
const hour = date.getHours();
if(hour<7 || hour >21){
    theme='dark';
}

if(window.matchMedia && window.matchMedia('(prefers-color-scheme:dark)').matches){
    theme='dark';
}
themeAppliquer();

button.addEventListener('click',()=>{
    theme = theme === 'light' ? 'dark' : 'light';
    themeAppliquer();
    localStorage.setItem('theme', theme); 
}) 


function themeAppliquer(){
    if (theme==='dark'){
        document.body.classList.remove("bg-light");
        document.body.classList.add("bg-dark","text-white");

        divsBgLight=document.getElementsByClassName("bg-light");
        for(let i=0;i<divsBgLight.length;++i){
            let div=divsBgLight[i];
            div.classList.remove("bg-light");            
        }

        divsBgWhite=document.getElementsByClassName("bg-white");
        for(let i=0;i<divsBgWhite.length;++i){
            let div=divsBgWhite[i];
            div.classList.remove("bg-white");
            div.classList.add("bg-dark");            
        }

        button.src="assets/iconeDarkModeBlanc.svg";

    } else {
        document.body.classList.remove("bg-dark","text-white");
        document.body.classList.add("bg-light");
        button.src="assets/iconeDarkModeNoir.svg";
        
        divsBgDark=document.getElementsByClassName("bg-dark");
        for(let i=0;i<divsBgDark.length;++i){
            let div=divsBgDark[i];
            div.classList.remove("bg-dark");           
        }

    }
}