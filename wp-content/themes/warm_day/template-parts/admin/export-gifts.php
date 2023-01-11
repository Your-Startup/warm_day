<?php 
/**
 * @var $count;
 */

global $allCities;
 
$directory = get_template_directory() . "/temp/";
$url       = get_template_directory_uri() . "/temp/";

$ignored = array('.', '..', '.svn', '.htaccess');
$files = array();
foreach (scandir($directory) as $file) {
    if (in_array($file, $ignored)) continue;
    $files[$file] = filemtime($directory . $file);
}
arsort($files);
$files = array_keys($files);
?>
<style>
    p {
        font-size: 16px;
    }

    .old-export-files {
        border: 1px solid #c3c4c7;
    }

    .old-export-file {
        padding: 10px;
    }

    .old-export-file:nth-child(odd) {
        background-color: #f6f7f7;
    }

    .old-export-files a {
        font-size: 16px;
        display: block;
        max-width: max-content;
    }

    .no-files {
        padding: 50px;
        text-align: center;
        font-size: 16px;
    }
</style>
<div class="wrap">
    <h2><?=  get_admin_page_title() ?></h2>
    <p>На данной странице вы можете выгрузить данные о <strong>забронированных</strong> подарках. Сейчас доступных к выгрузке записей: <strong><?= !empty($count) ? $count : 0 ?></strong>.</p>

    <select name="city" id="city">
        <option value="0">Все муниципальные образования</option>
        <?php foreach ($allCities as $city) : ?>
            <option value="<?= $city['id'] ?>"><?= $city['name'] ?></option>
        <?php endforeach; ?>
    </select>

    <select name="format" id="format">
        <option value="exel">Exel</option>
        <option value="google">Google таблицы</option>
    </select>
    
    <button id="export-gift" class="button action">Выгрузить новую</button>

    <h3>
        Старые выгрузки
    </h3>
    <div class="old-export-files">
        <?php if (!empty($files)) : ?>
            <?php foreach ($files as $key => $file) : ?>
                <div class="old-export-file">
                    <a href="<?= $url . $file?>" download><?= $file ?></a>
                </div>
            <?php endforeach;?>
        <?php else: ?>  
            <div class="no-files">
                Старых выгрузок нет
            </div>
        <?php endif;?>
    </div>
</div>

<iframe id="iframe" style="display:none;"></iframe>

<script>
    const btn    = document.getElementById('export-gift'),
          city   = document.getElementById('city'),
          format = document.getElementById('format');

    let is_sending = false;

    btn.addEventListener('click', () => {
        if (!is_sending) {
            is_sending = true;
            btn.setAttribute('disabled', 'disabled');
            btn.innerHTML = "Загрузка...";
            const data = new FormData();
            data.append('action', 'export_gifts');
            data.append('city', city.value);
            data.append('format', format.value);

            let xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= admin_url('admin-ajax.php') ?>');
            xhr.send(data);
        
            xhr.onload = function() {
                if (xhr.status != 200) {
                    console.log(`Ошибка ${xhr.status}: ${xhr.statusText}`);
                }  else {
                    const file     = JSON.parse(xhr.response),
                        files    = document.querySelector('.old-export-files'),
                        no_files = files.querySelector('.no-files');

                    if (no_files) {
                        no_files.remove();
                    }

                    const fileRow = document.createElement('div');
                    fileRow.classList.add('old-export-file');
                    const link = document.createElement('a');
                    link.setAttribute('href', file.link);
                    link.innerHTML = file.name;

                    fileRow.prepend(link);
                    files.prepend(fileRow);

                    download(file.link);
                }
                is_sending = false;
                btn.removeAttribute('disabled');
                btn.innerHTML = "Выгрузить новую";
            }
        
            xhr.onerror = function() {
                console.error("Запрос не удался");
                is_sending = false;
                btn.removeAttribute('disabled');
                btn.innerHTML = "Выгрузить новую";
            }

        } else {
            console.log('Запрос еще отправляется...');
        }
    });

    function download(url) {
        document.getElementById('iframe').src = url;
    };
</script>