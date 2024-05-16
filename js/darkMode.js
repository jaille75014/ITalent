button = document.getElementById("darkMode");
let theme= localStorage.getItem('theme') || 'light';
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

        button.src="assets/iconeDarkModeBlanc.svg";

        theme='dark';
    } else {
        document.body.classList.remove("bg-dark","text-white");
        document.body.classList.add("bg-light");
        button.src="assets/iconeDarkModeNoir.svg";
        theme='light';
    }
}