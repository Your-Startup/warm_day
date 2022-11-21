function formsInit() {
    const forms = document.querySelectorAll('form.request');

    let is_sending = [];
    for (let i = 0; i < forms.length; i++) {
        is_sending.push(false);
    }

    forms.forEach((form, key) => {
        const answer = form.querySelector('.form_answer');

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            if (!is_sending[key]) {
                is_sending[key] = true;
                form.classList.add('preload');

                setTimeout(() => {
                    let data = new FormData(form);
                    let xhr = new XMLHttpRequest();
                    xhr.open('POST', myajax.url);
                    xhr.send(data);
                
                    xhr.onload = function() {
                        let text = '';
                        if (xhr.status != 200) {
                            text = `Ошибка ${xhr.status}: ${xhr.statusText}`;
                        } else {
                            console.log(JSON.parse(xhr.response));
                            text = JSON.parse(xhr.response).message;
                        }
                        is_sending[key] = false;
                        form.classList.add('answer');
                        answer.innerHTML = text;
                    }
                
                    xhr.onerror = function() {
                        console.error("Запрос не удался");
                        is_sending[key] = false;
                        form.classList.add('answer');
                    }
                }, 600);
                
            } else {
                console.log('Запрос еще отправляется...');
            }
        });
    });
}

window.addEventListener('DOMContentLoaded', () => {
    formsInit();
});