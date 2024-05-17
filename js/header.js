const menuHamburger = document.querySelector(".burger-menu")
        const navLinks = document.querySelector(".nav-links")
 
        menuHamburger.addEventListener('click',()=>{
        let exist = navLinks.classList.toggle('mobile-menu');
        if(exist){
                header=document.getElementsByTagName("header")[0];
                header.style.opacity="1";
        }
})