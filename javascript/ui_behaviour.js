console.log('ui_behaviour.js script loaded and running');

//Hamburger menu toggle
const hamburger = document.getElementById('hamburger');
const navLinks = document.getElementById('navLinks');

hamburger.addEventListener('click', () => {
    navLinks.classList.toggle('show');
});

//Scroll to the top button toggle
const scrollBtn = document.getElementById("scrollToTopBtn");
window.addEventListener("scroll", () => {
    const quarterWay = window.innerHeight / 4;
    if (window.scrollY > quarterWay) {
        scrollBtn.classList.add("show");
    }
    else {
        scrollBtn.classList.remove("show");
    }
});

scrollBtn.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: "smooth"});
});

//Dark mode toggle
const toggle = document.getElementById("themeSwitch");
const logo = document.getElementById("site-logo");
document.addEventListener("DOMContentLoaded", () => {

    //loading dark theme from localstorage 
    if (localStorage.getItem("theme") === "dark") {
        document.documentElement.classList.add("dark-mode");
        toggle.checked = true;
        logo.src = "logos/horizontal_logo_light.png";
    } else {
        logo.src = "logos/horizontal_logo_dark.png";
    }
});

toggle.addEventListener("change", () => {
    const isDarkMode = document.documentElement.classList.toggle("dark-mode");
    localStorage.setItem("theme", isDarkMode ? "dark" : "light");
    logo.src = isDarkMode ? "logos/horizontal_logo_light.png" : "logos/horizontal_logo_dark.png";
});