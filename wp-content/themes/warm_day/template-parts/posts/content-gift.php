<?php 
global $post;
$gift = get_fields();?>

<section id="gift">
    <div class="container">
        <div class="gift">
            <img class="gift-img" src="<?= get_template_directory_uri() . '/assets/imgs/' . $gift['children']['gender'] . '.png'?>" alt="">
            <div class="gift-content">
                <div class="gift-children">
                    <h1><?= $gift['children']['name'] . ' ' . $gift['children']['age'] . ' ' . num2word($gift['children']['age'], ['год', 'года', 'лет']) ?></h1>
                    <p><?= $gift['children']['about'] ?></p>

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