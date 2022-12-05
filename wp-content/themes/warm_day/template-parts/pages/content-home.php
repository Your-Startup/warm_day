<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>

<section id="main">
    <?php $slider = get_field('slider'); ?>
    <?php if ($slider) : ?>
        <div class="main-swiper swiper">
            <div class="swiper-wrapper">
                <?php foreach ($slider as $slide) : ?>
                    <div class="swiper-slide">
                        <img src="<?= $slide ?>" alt="">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="swiper-prev">
            <svg width="14" height="24" viewBox="0 0 14 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.93934 10.9393C0.353553 11.5251 0.353553 12.4749 0.93934 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51472C13.1924 2.92893 13.1924 1.97919 12.6066 1.3934C12.0208 0.807611 11.0711 0.807611 10.4853 1.3934L0.93934 10.9393ZM3 10.5H2L2 13.5H3L3 10.5Z" fill="#4A4A4A"/>
            </svg>
        </div>
        <div class="swiper-next">
            <svg width="14" height="24" viewBox="0 0 14 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13.0607 13.0607C13.6464 12.4749 13.6464 11.5251 13.0607 10.9393L3.51472 1.3934C2.92893 0.807611 1.97919 0.807611 1.3934 1.3934C0.807611 1.97919 0.807611 2.92893 1.3934 3.51472L9.87868 12L1.3934 20.4853C0.807611 21.0711 0.807611 22.0208 1.3934 22.6066C1.97919 23.1924 2.92893 23.1924 3.51472 22.6066L13.0607 13.0607ZM11 13.5H12V10.5H11V13.5Z" fill="#4A4A4A"/>
            </svg>
        </div>
    <?php endif; ?>
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
        <h2>Информация об акции</h2>
        <?php $about = get_field('about'); ?>
        <?php if ($about) : ?>
            <div class="about-row">
                <?php foreach ($about as $item) : ?>
                    <div class="about-col">
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
            <h2>Как стать благодарителем?</h2>
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
                Подарить подарок
            </button>
        </div>
    </section>
<?php endif; ?>