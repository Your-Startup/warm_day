<?php 
global $post;
$gift = get_fields();
$categories = get_the_terms($post->ID, 'gift-categories');
$is_pensioner = false;
if ($categories) {
    foreach ($categories as $category) {
        if ($category->slug == 'pensioners') {
            $is_pensioner = true;
            break;
        }
    }
}
?>
<section id="gift">
    <div class="container">
        <div class="gift">
            <?php if ($is_pensioner) : ?>
                <img class="gift-img" src="<?= get_template_directory_uri() . '/assets/imgs/pensioner.png'?>" alt="">
            <?php else : ?>
                <img class="gift-img" src="<?= get_template_directory_uri() . '/assets/imgs/' . $gift['children']['gender'] . '.png'?>" alt="">
            <?php endif; ?>
            
            <div class="gift-content">
                <div class="gift-children">
                    <?php if ($is_pensioner) : ?>
                        <h1><?= $gift['children']['name'] ?></h1>
                        <div class="is_pensioner">
                            <?= $gift['children']['gender'] == 'man' ? 'Пенсионер' : 'Пенсионерка' ?>
                        </div>
                    <?php else : ?>
                        <h1><?= $gift['children']['name'] . ' ' . $gift['children']['age'] . ' ' . num2word($gift['children']['age'], $gift['children']['age_type'] ? ['год', 'года', 'лет'] : ['месяц', 'месяца', 'месяцев']) ?></h1>
                        <p><?= $gift['children']['about'] ?></p>
                    <?php endif; ?>
                    <div class="desktop">
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
                            <button class="js-popup-open" data-id="<?= $post->ID ?>" data-popup="order">
                                Забронировать подарок
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="gift-info">
                    <p><?= $gift['text'] ?></p>
                    <?php if (!empty($gift['img'])) : ?>
                        <img src="<?= $gift['img'] ?>" alt="">
                    <?php endif; ?>
                    <div class="mobile">
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
            </div>
        </div>
    </div>
</section>