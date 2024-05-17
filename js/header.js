const menuHamburger = document.querySelector(".burger-menu")
        const navLinks = document.querySelector(".nav-links")
 
        menuHamburger.addEventListener('click',()=>{
        let exist = navLinks.classList.toggle('mobile-menu');
        header=document.getElementsByTagName("header")[0];
        if(exist){
                header.style.opacity="1";
        } else {
                header.style.opacity="0.8";  
        }
})