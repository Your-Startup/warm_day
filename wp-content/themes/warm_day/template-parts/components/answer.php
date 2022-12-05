<?php
/**
 * @var $title
 * @var $text
 * @var $is_order
 */
?>

<div class="answe_logo">
    <img src="<?= get_template_directory_uri() . '/assets/imgs/logo.png'?>" alt="">
</div>
<div class="answer_content">
    <div class="answer_title">
        <?= $title ?>
    </div>
    <div class="answer_text">
        <?= $text ?>
        <?php if ($is_order) : ?>
            <span class="tip">
                *Некоторые почтовые сервисы отправляют наши письма в спам, обязательно проверьте эту папку. Если остались вопросы, свяжитесь с нами через форму обратной связи.
            </span>
        <?php endif; ?>
    </div>
</div>
<div class="answer_footer">
    <?php $socials = get_field('socials', 'options');?> 
    <?php if ($socials) : ?>
        <div class="socials">
            Мы в соц. сетях:
            <?php foreach ($socials as $social) : ?>
                <a href="<?= $social['link'] ?>" target="_blank">
                    <img src="<?= $social['icon'] ?>" alt="">
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>