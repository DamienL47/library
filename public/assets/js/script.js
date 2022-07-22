const body = document.querySelector('body');

if (localStorage.getItem('js-night-mode') === 'true') {
    body.setAttribute('class','js-night');
}

const button = document.querySelector('.js-night-mode');

button.addEventListener('click',() => {
    if (body.getAttribute('class')){
        body.removeAttribute('class');
        button.innerText = "Night Mode";
        localStorage.removeItem('js-night-mode');
    } else {
        body.setAttribute('class','js-night');
        button.innerText = "Light Mode";
        localStorage.setItem('js-night-mode', "true");
    }
});

const burgerButton = document.querySelector('.nav-toggler');
const navigation = document.querySelector('.burgerMenu')
burgerButton.addEventListener("click",
    toggleNav)

function toggleNav(){
    burgerButton.classList.toggle("active")
    navigation.classList.toggle("active")
}