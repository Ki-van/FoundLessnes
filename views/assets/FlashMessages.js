export function setFlashMessage(message, success = true, timer = 5000) {
    let container = document.createElement('div');
    container.setAttribute('class', 'alert ' + success?'alert-success':'alert-fail');
    container.style.opacity = "0%";
    container.innerHTML = "<p>"+message+"</p>";
    document.querySelector('nav').after(container);
    unfade(container);
    setTimeout(async ()=>
    {
        fade(container);
        setTimeout(()=>container.remove(), 50);
    }, timer);
}

function fade(element) {
    var op = 1;  // initial opacity
    var timer = setInterval(function () {
        if (op <= 0.1){
            clearInterval(timer);
            element.style.display = 'none';
        }
        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ")";
        op -= op * 0.1;
    }, 50);
}

async function unfade(element) {
    var op = 0.1;  // initial opacity
    element.style.display = 'block';
    var timer = setInterval(function () {
        if (op >= 1){
            clearInterval(timer);
        }
        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ")";
        op += op * 0.1;
    }, 10);
}