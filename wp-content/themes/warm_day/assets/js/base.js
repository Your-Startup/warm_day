function formsInit() {
    const forms = document.querySelectorAll('form.js-request');

    let is_sending = [];
    for (let i = 0; i < forms.length; i++) {
        is_sending.push(false);
    }

    forms.forEach((form, key) => {
        const answer = form.querySelector('.form_answer'),
              action = form.querySelector('input[name="action"]').value;

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
                        form.classList.remove('preload');
                        answer.innerHTML = text;

                        switch (action) {
                            case 'feedback':
                                ym(91564746,'reachGoal','feedback');
                                break;
                            case 'order':
                                ym(91564746,'reachGoal','order');
                                break;
                        }
                    }
                
                    xhr.onerror = function() {
                        console.error("Запрос не удался");
                        is_sending[key] = false;
                        form.classList.add('answer');
                        form.classList.remove('preload');
                    }
                }, 600);
            } else {
                console.log('Запрос еще отправляется...');
            }
        });
    });
}

let popup, contents, closeBtn;

function popupInit() {
    popup    = document.querySelector('.popup');
    contents = popup.querySelectorAll('.popup-content');
    closeBtn = popup.querySelector('.popup-close');

    document.addEventListener('click', (e) => {
        const open = e.target.closest('.js-popup-open');

        if (!open) {
            return;
        }

        if (!open.dataset.popup) {
            return;
        }

        openPopup(open.dataset.popup, open);
    });

    closeBtn.addEventListener('click', () => {
        popup.classList.remove('open');
        const form = popup.querySelector('form');
        if (form) {
            form.classList.remove('answer');
            form.classList.remove('preload');
        }
    });
}

function openPopup(id, open) {
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

function phoneMasksInit() {
    const phones = document.querySelectorAll('input[type="tel"]');

    phones.forEach((phone) => {
        new Cleave(phone, {
            phone: true,
            phoneRegionCode: 'ru'
        });
    });
}

function initMobileMenu() {
    const header   = document.querySelector('header'),
          menuBtn  = header.querySelector('.mobile-menu-btn'),
          menuItem = header.querySelectorAll('.menu-item');
     
    menuBtn.addEventListener('click', () => {
        header.classList.toggle('open');
    });

    menuItem.forEach(item => {
        item.addEventListener('click', () => {
            header.classList.remove('open');
        });
    });
}

function fileInputInit() {
    const inputs = document.querySelectorAll('input[type="file"]');

    inputs.forEach((input) => {
        input.addEventListener('change', () => {
            const label = document.querySelector('label[for="' + input.id + '"]');
            if (input.files.item(0)) {
                label.querySelector('.file-name').innerHTML = input.files.item(0).name;
                label.classList.add('file');
            } else {
                label.querySelector('.file-name').innerHTML = '';
                label.classList.remove('file');
            }
        });
    });
}

window.addEventListener('DOMContentLoaded', () => {
    formsInit();
    popupInit();
    phoneMasksInit();
    initMobileMenu();
    fileInputInit();
});