let form = document.querySelector('.art-post-body form');
form.addEventListener('submit', function (event) {

    let res = true;
    let regEmail = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    let regPlanText = /[а-яА-ЯёЁ \w]*/

    let fields = form.querySelectorAll('.field')
    for (let i = 0; i < fields.length; i++) {
        if (!fields[i].value) {
            fields[i].classList.add("validation-error");
            event.preventDefault();
            return;
        } else
        {
            fields[i].classList.remove("validation-error");
        }
    }

    let theme = document.querySelector('form input[name="article-theme"]');
    let brief = document.querySelector('form textarea');
    let email = document.querySelector('form input[name="email"]');
    if(!isValid(regPlanText, theme.value))
    {
        theme.classList.add("validation-error");
        res = false;
    } else {
        theme.classList.remove("validation-error");
    }

    if(!isValid(regPlanText, brief.tex))
    {
        brief.classList.add("validation-error");
        res = false;
    } else {
        brief.classList.remove("validation-error");
    }

    if(!isValid(regEmail, email.value))
    {
        email.classList.add("validation-error");
        res = false;
    } else {
        email.classList.remove("validation-error");
    }

    if(!res)
        event.preventDefault();
});

function isValid(reg, text){
    return reg.test(text);
}
