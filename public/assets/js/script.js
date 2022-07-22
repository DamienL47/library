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
        button.innerText = "light Mode";
        localStorage.setItem('js-night-mode', "true");
    }
});
