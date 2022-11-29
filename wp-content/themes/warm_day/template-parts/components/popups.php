<?php
require_once( ABSPATH . 'wp-admin/includes/image.php' );
require_once( ABSPATH . 'wp-admin/includes/file.php' );
require_once( ABSPATH . 'wp-admin/includes/media.php' );

global $post;
global $allCities;
global $current_city;

if (!empty($post) && $post->post_type == 'gift') {
    $cityID = get_field('children', $post->ID)['city'];
    $current_city = get_post($cityID);
}

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
                    <div class="popup-scroll">
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
                </div>
            <?php endif; ?>
            <?php if (in_array($pagename, ['catalog', 'gift'])) : ?>
                <div class="popup-content" id="order">
                    <form class="order js-request">
                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="action" value="order">
                        <input type="hidden" name="city" value="<?= $current_city->post_title ?>">
                        <h3>Чтобы забронировать подарок, заполните информацию о себе:</h3>
                        <div class="popup-scroll">
                            <label for="">
                                Муниципальное образование
                                <input type="text" id="order_city" required value="<?= $current_city->post_title ?>" disabled>
                            </label>
                            <label for="">
                                ФИО дарителя*
                                <input type="text" name="name" id="order_name" required>
                            </label>
                            <label for="">
                                Организация
                                <input type="text" name="company" id="order_company">
                            </label>
                            <input type="file" name="logo_company" id="order_logo_company" accept=".png, .jpg, .jpeg">
                            <label for="order_logo_company">
                                Логотип организации
                                <div class="file-container">
                                    <div class="file-icon">
                                       <img src="<?= get_template_directory_uri() . '/assets/imgs/file.svg' ?>" alt="">
                                    </div>
                                    <div class="file-name">
                                        
                                    </div>
                                </div>
                            </label>
                            <label for="">
                                Номер телефона*
                                <input type="tel" name="phone" id="order_phone" required pattern="\+7 \d{3} \d{3} \d{2} \d{2}|8 \d{3} \d{3} \d{2} \d{2}">
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