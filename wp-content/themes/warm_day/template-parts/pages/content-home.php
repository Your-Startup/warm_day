<section id="main" style="background-image: url('<?= get_field('background')?>');">
    <div class="main-top">
        <?= get_field('company') ?>
    </div>
    <div class="main-content">
        <h1><?= get_field('title') ?></h1>
        <button class="big-btn blue-btn js-popup-open" data-popup="city">
            Подарить подарок
        </button>
    </div>
    <div class="main-bottom">
        <?php $question_link = get_field('question_link', 'options');?>
        <?php if ($question_link) : ?>
            <a href="<?= $question_link ?>" target="_blank" class="question">
                Есть вопрос или предложение?
            </a>
        <?php else: ?> 
            <div></div>
        <?php endif; ?>  
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
</section>
<section id="about">
    <div class="container">
        <h2>Информация о проекте</h2>
        <?php $about = get_field('about'); ?>
        <?php if ($about) : ?>
            <div class="about-row">
                <?php foreach ($about as $item) : ?>
                    <div class="about-col">
                        <img src="<?= $item['icon'] ?>" alt="">
                        <?= $item['text'] ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="about-content">
            <div class="about-text">
                <?php $img = get_field('img')?>
                <?php if ($img) : ?>
                    <img src="<?= $img ?>" align="right" alt="">
                <?php endif; ?>
                <?= get_field('text') ?>
            </div>
        </div>
    </div>
</section>
<?php $how = get_field('how-it-works'); ?>
<?php if ($how) : ?>
    <section id="how-it-works">
        <div class="container">
            <h2>Как это работает?</h2>
            <div class="how-it-works-content">
                <?php foreach ($how as $key => $item) : ?>
                    <div class="how-it-works-item">
                        <div class="how-it-works-title">
                            <div class="number">
                                <?= $key + 1 ?>
                            </div>
                            <?= $item['title']; ?>
                        </div>
                        <?= $item['text']; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="big-btn blue-btn js-popup-open" data-popup="city">
                Стать дарителем
            </button>
        </div>
    </section>
<?php endif; ?>