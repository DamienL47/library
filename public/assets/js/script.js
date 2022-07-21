const button = document.querySelector('.js-night-mode');

button.addEventListener('click',(e) => {
    e = document.querySelector('body');
    if (e.getAttribute('class')){
        e.removeAttribute('class');
        button.innerText = "Night Mode";
    } else {
        e.setAttribute('class','js-night');
        button.innerText = "light Mode";
    }
});

