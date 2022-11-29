<?php
/**
 * @var $gifts;
 */
?>

<?php if ($gifts['items']) : ?>
    <div class="gift-list">
        <?php foreach ($gifts['items'] as $gift) : ?>
            <div class="gift" >
                <img class="gift-img" src="<?= get_template_directory_uri() . '/assets/imgs/' . $gift['children']['gender'] . '.png'?>" alt="">
                <div class="gift-info">
                    <a class="gift-title" href="<?= get_permalink($gift['id']) ?>">
                        <?= $gift['children']['name'] ?>, <?= $gift['children']['age'] . ' ' . num2word($gift['children']['age'], ['год', 'года', 'лет']) ?><br>
                    </a>
                    <div class="gift-text">
                        <?= $gift['text'] ?>
                    </div>
                    <?php if ($gift['order']['is_ordered']) :?>
                        <div class="gift-ordered">
                            <?php if ($gift['order']['is_show']) : ?>
                                <?php if ($gift['order']['company']) : ?>
                                    <span>Подарок забронировала организация: </span>
                                    <?php if ($gift['order']['logo_company']) : ?>
                                        <img src="<?= $gift['order']['logo_company'] ?>" alt="">
                                    <?php endif; ?>
                                    <?= $gift['order']['company'] ?>
                                <?php else: ?>
                                    Подарок забронировал(а): <br>
                                    <?= $gift['order']['name'] ?>
                                <?php endif; ?>
                            <?php else: ?>
                                Подарок забронирован
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <button class="js-popup-open" data-id="<?= $gift['id'] ?>" data-popup="order">
                            Забронировать подарок
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php $pagination = $gifts['pagination'] ?>
    <?php include_once(get_template_directory().'/template-parts/components/pagination.php')?>
<?php else: ?>
    <div class="gift-list">
        <div class="no-result">
            <h3>Подарков по такому запросу не найдено :(</h3>
            <p>Попробуйте изменить фильтры.</p>      
        </div>
    </div>
<?php endif; ?>