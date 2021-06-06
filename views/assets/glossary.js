document.querySelectorAll(".art-post-content p a").forEach(element => {
    if (!element.hasAttribute("name"))
        return;
    element.focused = false;
    element.onmouseover = (event) => {
        this.focused = true;
        setTimeout(() => {
            if (this.focused) {
                const body = { word: event.target.getAttribute("name") };
                const url = "/foundlessness/resourses/word_definition.php";

                try {
                    fetch(url, {
                        method: 'POST',
                        body: JSON.stringify(body),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    }).then(response=>{
                        response.json().then(response=>{
                            let box = event.target.getBoundingClientRect();

                            var tempDiv = document.createElement('div');
                            tempDiv.classList.add("word-popup-container");
                            tempDiv.style.left = box.left + pageXOffset + "px";
                            tempDiv.style.top = box.bottom + pageYOffset + "px";
                            tempDiv.innerHTML = response.definition;
                            tempDiv.onmouseout = (event) => {
                                setTimeout(() => {
                                    event.target.parentNode.removeChild(event.target);
                                }, 100);
                            };


                            document.body.insertAdjacentElement("afterend", tempDiv);
                        });

                    });
                } catch (error) {
                    console.error('Ошибка:', error);
                }

            }
        }, 1000);
    }
    element.onmouseout = () => {
    };
    element.onmouseout = () => {
        this.focused = false;
    };
});

function getDefinition() {

}