
const dark = "rgb(82, 82, 82)";
const light = "#EFEFEF";

document.addEventListener('DOMContentLoaded', function() {
    
    window.onscroll = () => navAnimation();
    if (window.innerWidth < 768)
        burgerAnimation();
    window.onresize = () => {
        if (window.innerWidth < 768)
        burgerAnimation();
    }
});


function navAnimation() {
    
    const nav = document.querySelector('header nav');
    const logo = document.querySelector('.logo');
    const logoName = document.querySelector('.logo-name');
    const links = document.querySelectorAll('.nav-links li a');
    const burgerLines = document.querySelectorAll('.burger div');

    if (window.scrollY > 10) {
        lightNav(nav, logo, logoName, links, burgerLines);
    } else {
        darkNav(nav, logo, logoName, links, burgerLines);
    }
}


function lightNav(nav, logo, logoName, links, burgerLines, delay=0) {
    setTimeout(() => {
        nav.classList.add('nav-scroll');
        logo.src = assetBaseUrl + "images/Black Logo.png";
        logoName.classList.add('nav-link-scroll');
        links.forEach(link => {
            link.classList.add('nav-link-scroll');
        })
        burgerLines.forEach(line => {
            line.style.backgroundColor = dark;
        });
    }, delay);
}


function darkNav(nav, logo, logoName, links, burgerLines, delay=0) {
    setTimeout(() => {
        nav.classList.remove('nav-scroll');
        logoName.classList.remove('nav-link-scroll');
        links.forEach(link => {
            link.classList.remove('nav-link-scroll');
        })
        if (nav.dataset.theme === "light") {
            logo.src = assetBaseUrl + "images/Black Logo.png";
            burgerLines.forEach(line => {
                line.style.backgroundColor = dark;
            });
        } else {
            logo.src = assetBaseUrl + "images/White Logo.png";
            burgerLines.forEach(line => {
                line.style.backgroundColor = light;
            });
        }
    }, delay);
}


function burgerAnimation() {
    const nav = document.querySelector('header nav');
    const logo = document.querySelector('.logo');
    const logoName = document.querySelector('.logo-name');
    const links = document.querySelectorAll('header nav ul li a');

    const burger = document.querySelector('.burger');
    const navLinks = document.querySelector('.nav-links');
    const burgerLines = document.querySelectorAll('.burger div');

    burger.onmouseover = () => {
        burgerLines.forEach(line => {
            line.classList.toggle('burger-hover');
        });
    }
    burger.onmouseout = () => {
        burgerLines.forEach(line => {
            line.classList.remove('burger-hover');
        });
    }

    burger.onclick = () => {
        navLinks.classList.toggle('nav-open');
        burgerLines.forEach(line => {
            line.classList.toggle('burger-clicked');
        });
        if (navLinks.classList.contains('nav-open'))
            lightNav(nav, logo, logoName, links, burgerLines, 200);
        else if (window.scrollY <= 10 && !navLinks.classList.contains('nav-open'))
            darkNav(nav, logo, logoName, links, burgerLines, 450);
    }
}
