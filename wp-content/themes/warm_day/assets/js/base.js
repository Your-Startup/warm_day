function formsInit() {
    const forms = document.querySelectorAll('form.js-request');

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

let popup, contents, closeBtn, opens;

function popupInit() {
    popup    = document.querySelector('.popup');
    contents = popup.querySelectorAll('.popup-content');
    closeBtn = popup.querySelector('.popup-close');
    opens    = document.querySelectorAll('.js-popup-open');

    opens.forEach((open) => {
        open.addEventListener('click', () => {
            if (!open.dataset.popup) {
                return;
            }
            openPopup(open.dataset.popup);
        });
    });

    closeBtn.addEventListener('click', () => {
        popup.classList.remove('open');
    });
}

function openPopup(id) {
    if (!id) {
        return;
    }

    const current_popup = popup.querySelector('#' + id);

    if (!current_popup) {
        return;
    }

    contents.forEach((content) => {
        content.classList.remove('active');
    });

    current_popup.classList.add('active');

    popup.classList.add('open');
    if (open.dataset.id) {
        popup.querySelector('input[name=id]').value = open.dataset.id;
    }
}

window.addEventListener('DOMContentLoaded', () => {
    formsInit();
    popupInit();
});