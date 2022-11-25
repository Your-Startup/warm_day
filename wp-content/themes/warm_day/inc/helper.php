<?php
$allCities = [];

add_action('acf/init', 'getAllCities');
function getAllCities() {
    $allCityPosts = get_posts( array(
        'numberposts' => -1,
        'orderby'     => 'date',
        'order'       => 'ASC',
        'post_type'   => 'city',
        'post_status' => 'publish, private',
        'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
    ) );
    
    global $allCities;
    if (!empty($allCityPosts)) {
        foreach ($allCityPosts as $key => $cityPost) {
            $allCities[] = array(
                'id' => $cityPost->ID,
                'name' => $cityPost->post_title,
                'img' => get_the_post_thumbnail_url($cityPost->ID),
                'point' => get_field('point', $cityPost->ID),
            );
        }
    } 
}

function getCurrentCity()
{
    if (empty($_GET['cityId'])) {
        return false;
    }

    return get_post($_GET['cityId']);
}

$current_city = getCurrentCity();

function getGifts($city_id, $page = 1) {
    if (!$city_id) {
        return;
    }

    $count = wp_count_posts( 'gift' );

    $giftPosts = get_posts( array(
        'numberposts' => 6,
        'offset'      => $page * 6 - 6,
        'orderby'     => 'date',
        'order'       => 'ASC',
        'post_type'   => 'gift',
        'meta_key'    => 'children_city',
        'meta_value'  => $city_id,
        'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
    ) );

    $gifts = [
        /*'pagination' => [
            'page' => $page,
            'pages' => ceil($count->publish / 6),
        ],*/

        'pagination' => [
            'page' => 6,
            'pages' => 8,
        ],
        'items' => [],
    ];

    if ($giftPosts) {
        foreach ($giftPosts as $key => $gift) {
            $gifts['items'][] = [
                'id' => $gift->ID,
                'children' => get_field('children', $gift->ID),
                'text' => get_field('text', $gift->ID),
                'order' => get_field('order', $gift->ID),
            ];
        }
    } 

    return $gifts;
}

function num2word($n, $titles) {
    $cases = array(2, 0, 1, 1, 1, 2);
    return $titles[($n % 100 > 4 && $n % 100 < 20) ? 2 : $cases[min($n % 10, 5)]];
}