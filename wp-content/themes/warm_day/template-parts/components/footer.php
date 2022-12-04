<?php global $allCities; ?>

<section id="contacts">
    <div class="container">
        <h2>Контакты и обратная связь</h2>
        <div class="contacts-container">
            <form id="feedback" class="request js-request">
                <h3>Форма обратной связи</h3>
                <div class="feedback-col">
                    <input type="hidden" name="action" value="feedback">
                    <label for="">
                        Имя
                        <input type="text" name="name" id="feedback_name" required>
                    </label>
                    <label for="">
                        Телефон
                        <input type="tel" name="phone" id="feedback_phone" required pattern="\+7 \d{3} \d{3} \d{2} \d{2}|8 \d{3} \d{3} \d{2} \d{2}">
                    </label>
                    <label for="">
                        Электронная почта
                        <input type="email" name="email" id="feedback_email" required>
                    </label>
                </div>
                <div class="feedback-col">
                    <label for="">
                        Вопрос
                        <textarea name="text" id="feedback_text" cols="30" rows="5"></textarea>
                    </label>
                    <button type="submit">
                        Отправить
                        <svg width="24" height="12" viewBox="0 0 24 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 6H23M23 6L18.0714 1M23 6L18.0714 11" stroke="white"/>
                        </svg>
                    </button>
                    <input type="checkbox" id="feedback_pp" checked required>
                    <label for="feedback_pp">Даю согласие на&nbsp<a href="/privacy-policy" target="_blank">обработку персональных данных</a></label>
                </div>

                <div class="form_preloader">
                    <div class="lds-dual-ring"></div>
                </div>
                <div class="form_answer">

                </div>
            </form>
            <div class="acceptance-points-conteiner">
                <h3>Пункты приема подарков</h3>
                <div class="acceptance-points">
                    <?php if ($allCities) : ?>
                        <?php foreach ($allCities as $city) : ?>
                            <?php if (!empty($city['point']['address'])) : ?>
                                <div class="point">
                                    <div class="point-img">
                                        <img src="<?= $city['img'] ?>" alt="">
                                    </div>
                                    <div class="point-title">
                                        <?= $city['name'] ?>
                                    </div>
                                    <div class="point-text">
                                        <?php foreach ($city['point']['address'] as $address) : ?>
                                            <span><?= $address['city'] ?></span> – <?= $address['address'] ?><br>
                                        <?php endforeach; ?>   
                                        <?php if (!empty($city['point']['fio'])) : ?>
                                            <br><span>Ответственный(ая): </span><?= $city['point']['fio'] ?>
                                            <?php if (!empty($city['point']['phone_number'])) : ?>
                                                <br><span>тел: </span><?= $city['point']['phone_number'] ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>                             
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="acceptance-points-footer">
                    <?php $question_link = get_field('question_link', 'options');?>
                    <?php if ($question_link) : ?>
                        <a href="<?= $question_link ?>" target="_blank" class="questions">
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
            </div>
        </div>
    </div>
</section>