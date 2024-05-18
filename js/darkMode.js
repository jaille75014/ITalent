button = document.getElementById("darkMode");
let theme= localStorage.getItem('theme') || 'light';

const date = new Date() ;
const hour = date.getHours();
if(hour<7 || (hour>21 && hour<=24)){
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

        header=document.getElementsByTagName("header")[0];
        header.classList.remove("bg-light");
        header.classList.add("bg-dark");

        
        document.documentElement.setAttribute('data-bs-theme','dark');

        
        button.src="/assets/iconeDarkModeBlanc.svg";

    } else {
        document.body.classList.remove("bg-dark","text-white");
        document.body.classList.add("bg-light");
        button.src="/assets/iconeDarkModeNoir.svg";


        header=document.getElementsByTagName("header")[0];
        header.classList.remove("bg-dark");
        header.classList.add("bg-light");
        
        
        document.documentElement.setAttribute('data-bs-theme','white');

    }
}