let saved_filters = null;

function filtersInit() {
    const filters       = document.querySelector('.filters'),
          checkboxes    = filters.querySelectorAll('input[type=checkbox]'),
          material      = filters.querySelector('#material'),
          no_material   = filters.querySelector('#no_material'),
          booked        = filters.querySelector('#booked'),
          free          = filters.querySelector('#free'),
          all           = filters.querySelector('#all'),
          select        = filters.querySelector('.select'),
          select_header = filters.querySelector('.select-header'),
          drop          = filters.querySelector('.js-drop-filters');

    material.onchange = () => {
        if (material.checked) {
            no_material.checked = false;
        }
    }

    no_material.onchange = () => {
        if (no_material.checked) {
            material.checked = false;
        }
    }

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
    
    if (select && select_header) {
        select_header.addEventListener('click', () => {
            select.classList.toggle('active');
        });
    }
    
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
        filters.querySelector('input[name="page"]').value = 1;
        const data = new FormData(filters);
        submit(data);
    });

    filters.addEventListener('submit', (e) => {
        e.preventDefault();
        filters.querySelector('input[name="page"]').value = 1;
        const data = new FormData(filters);
        submit(data);
    });
}

let is_sending = false;

function submit(data) {
    if (!is_sending) {
        is_sending = true;
        saved_filters = data;
        data.append('action', 'catalog_filter');

        openPreloader();

        setTimeout(() => {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', myajax.url);
            xhr.send(data);
        
            xhr.onload = function() {
                if (xhr.status != 200) {
                    console.log(`Ошибка ${xhr.status}: ${xhr.statusText}`);
                } else {
                    const result = JSON.parse(xhr.response);

                    if (result.success) {
                        document.querySelector('.gift-content').innerHTML = result.template;
                    } else {
                        console.log(result.message);
                    }
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
    document.querySelector('#catalog').scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
    const container  = document.querySelector('.gift-container');
    container.classList.add('preload');
}

function closePreloader() {
    const container  = document.querySelector('.gift-container');
    container.classList.remove('preload');
}

function initPagination() {
    document.addEventListener('click', (e) => {
        const pagination = e.target.closest('.js-pagination');

        if (!pagination) {
            return;
        }

        if (!pagination.dataset.page) {
            return;
        }
        
        document.querySelector('.filters input[name="page"]').value = pagination.dataset.page;

        const data = saved_filters ? saved_filters : new FormData(),
              city = document.querySelector('.filters input[name="city"]').value;

        data.set('page', pagination.dataset.page);
        data.set('city', city);
        submit(data);
    });
}

window.addEventListener('DOMContentLoaded', () => {
    filtersInit();
    initPagination();
});