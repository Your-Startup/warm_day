function filtersInit() {
    const filters       = document.querySelector('.filters'),
          checkboxes    = filters.querySelectorAll('input[type=checkbox]'),
          booked        = filters.querySelector('#booked'),
          free          = filters.querySelector('#free'),
          all           = filters.querySelector('#all'),
          select        = filters.querySelector('.select'),
          select_header = select.querySelector('.select-header'),
          drop          = filters.querySelector('.js-drop-filters');

    booked.onchange = free.onchange = () => {
        if (booked.checked && free.checked) {
            all.checked = true;
        } else {
            all.checked = false;
        }
    }

    all.onchange = () => {
        if (all.checked) {
            booked.checked = true;
            free.checked   = true;
        } else {
            booked.checked = false;
            free.checked   = false;
        }
    }
    
    select_header.addEventListener('click', () => {
        select.classList.toggle('active');
    });

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            let is_disabled = true;
            checkboxes.forEach(item => {
                if (item.checked) {
                    is_disabled = false;
                    return;
                } 
            });
            if (is_disabled) {
                drop.setAttribute('disabled', 'disabled');
            } else {
                drop.removeAttribute('disabled');
            }
        });
    });
    

    drop.addEventListener('click', () => {
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        drop.setAttribute('disabled', 'disabled');
        submit(filters);
    });

    filters.addEventListener('submit', (e) => {
        e.preventDefault();
        submit(filters);
    });
}

let is_sending = false;

function submit(form) {
    if (!is_sending) {
        is_sending = true;
        openPreloader();

        setTimeout(() => {
            let data = new FormData(form);
            data.append('action', 'catalog_filter');
    
            let xhr = new XMLHttpRequest();
            xhr.open('POST', myajax.url);
            xhr.send(data);
        
            xhr.onload = function() {
                if (xhr.status != 200) {
                    console.log(`Ошибка ${xhr.status}: ${xhr.statusText}`);
                } else {
                    console.log(JSON.parse(xhr.response));
                }
                is_sending = false;
                closePreloader();
            }
        
            xhr.onerror = function() {
                console.error("Запрос не удался");
                is_sending = false;
                closePreloader();
            }
        }, 600);
        
    } else {
        console.log('Запрос еще отправляется...');
    }
}

function openPreloader() {
    const container  = document.querySelector('.gift-container');
    container.classList.add('preload');
}

function closePreloader() {
    const container  = document.querySelector('.gift-container');
    container.classList.remove('preload');
}

window.addEventListener('DOMContentLoaded', () => {
    filtersInit();
});