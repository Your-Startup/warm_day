<?php
global $post;
global $allCities;
global $current_city;

$is_non_city = !$current_city && $pagename == 'catalog';

if ($post) : ?>
    <?php $pagename = $post->post_name;?>
    <?php if (is_single() || is_tax()) $pagename = $post->post_type; ?>
    <div class="popup<?= $is_non_city ? ' open"' : ''?>">
        <div class="popup-container">
            <div class="popup-close" <?= $is_non_city ? 'style="display:none"' : ''?>>
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M25 7L7 25" stroke="#145C8E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M25 25L7 7" stroke="#145C8E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <?php if ($allCities) : ?>
                <div class="popup-content<?= $is_non_city ? ' active"' : ''?>" id="city">
                    <h3>Выбор муниципального образования, где вы находитесь</h3>
                    <ul class="cities">
                        <?php foreach ($allCities as $city) : ?>
                            <li>
                                <a href="/catalog?cityId=<?= $city['id'] ?>">
                                    <img src="<?= $city['img'] ?>" alt="">
                                    <?= $city['name'] ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php if ($pagename == 'catalog') : ?>
                <div class="popup-content" id="order">
                    <form class="order js-request">
                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="action" value="order">
                        <h3>Чтобы забронировать подарок, заполните информацию о себе:</h3>
                        <div class="popup-scroll">
                            <label for="">
                                Муниципальное образование*
                                <input type="text" name="city" id="order_city" required>
                            </label>
                            <label for="">
                                ФИО дарителя*
                                <input type="text" name="name" id="order_company" required>
                            </label>
                            <label for="">
                                Организация
                                <input type="text" name="company" id="order_company">
                            </label>
                            <label for="">
                                Номер телефона*
                                <input type="text" name="phone" id="order_phone" required>
                            </label>
                            <label for="">
                                Почта*
                                <input type="email" name="email" id="order_email" required>
                            </label>
                            <button type="submit">
                                Забронировать подарок
                            </button>
                            <input type="checkbox" id="order_pp" checked required>
                            <label for="order_pp">Даю согласие на обработку персональных данных</label>
                            <input type="checkbox" id="order_show" name="is_show" checked>
                            <label for="order_show">Хотите ли вы отображаться на забронированном товаре?</label>
                        </div>
                        <div class="form_preloader">
                            <div class="lds-dual-ring"></div>
                        </div>
                        <div class="form_answer">

                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>