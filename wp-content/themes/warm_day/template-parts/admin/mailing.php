<?php 
/**
 * @var $count;
 */
?>
<style>
    p {
        font-size: 16px;
    }

    .flex {
        display: flex;
        align-items: center;
    }

    #mailing {
        margin-right: 20px;
    }
    
    progress {
        margin-right: 20px;
        display: none;
    }

    progress.active {
        display: block;
    }

    .log {
        max-height: 200px;
        max-width: 400px;
        overflow: auto;
        padding: 10px;
        background: #fff;
    }
</style>
<div class="wrap">
    <h2><?=  get_admin_page_title() ?></h2>
    <p>На данной странице вы можете вручную запустить рассылку по <strong>забронированным</strong> подаркам. Сейчас доступных к рассылке подарков: <strong><?= !empty($count) ? $count : 0 ?></strong>.</p>
    
    <div class="flex">
        <button id="mailing" class="button action">Запустить рассылку</button>
        <progress max="100" value="0"></progress>
        <div class="progress-text">
            
        </div>
    </div>

    <h4>Собщения отправлены на: </h4>
    <div class="log">

    </div>
</div>
<script>
    const btn          = document.getElementById('mailing'),
          progress     = document.querySelector('progress'),
          progressText = document.querySelector('.progress-text'),
          log          = document.querySelector('.log');

    let count = 1,
        offset = 0,
        id;

    btn.addEventListener('click', () => {
        count = 1;
        offset = 0;
        log.innerHTML = '';
        btn.setAttribute('disabled', 'disabled');
        btn.innerHTML = "Идет рассылка...";
        progress.classList.add('active');
        progress.setAttribute('max', 100);
        progress.value = 0;

        id = setInterval(() => {
            sendMail(offset);
            offset++;
        }, 6000);
    });

    function sendMail(offset) {
        if (count <= offset) {
            btn.removeAttribute('disabled');
            btn.innerHTML = "Запустить рассылку";
            progress.classList.remove('active');
            progressText.innerHTML = offset + ' из ' + count; 
            clearInterval(id);
            return;
        }

        const data = new FormData();
        data.append('action', 'mailing');
        data.append('offset', offset);

        let xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= admin_url('admin-ajax.php') ?>', true);
        xhr.send(data);
    
        xhr.onload = function() {
            if (xhr.status != 200) {
                btn.removeAttribute('disabled');
                btn.innerHTML = "Запустить рассылку";
                progress.classList.remove('active');
                progressText.innerHTML = `Ошибка ${xhr.status}: ${xhr.statusText}`;
            }  else {
                const response = JSON.parse(xhr.response);
                
                if (response.status == 'error') {
                    btn.removeAttribute('disabled');
                    btn.innerHTML = "Запустить рассылку";
                    progress.classList.remove('active');
                    progressText.innerHTML = offset + ' из ' + count + ' ошибка';
                    clearInterval(id);
                } else { // loading
                    count = response.max;
                    progress.setAttribute('max', response.max);
                    progress.value = offset;
                    progressText.innerHTML = offset + ' из ' + count;
                    const logRow = document.createElement('div');
                    logRow.innerHTML = response.email;
                    log.append(logRow);
                }
            }
        }

        xhr.onerror = function() {
            btn.removeAttribute('disabled');
            btn.innerHTML = "Запустить рассылку";
            progress.classList.remove('active');
            progressText.innerHTML = offset + ' из ' + count + ' Запрос не удался';
            clearInterval(id);
        }
    }
</script>