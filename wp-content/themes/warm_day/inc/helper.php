<?php
function the_custom_logo_2() {
    $header_logo = get_theme_mod('header_logo');
    $img = wp_get_attachment_image_src($header_logo, 'full');
    if ($img) {
        echo '<img src="' . $img[0] . '" alt="">';
    }
}

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

function getGifts($params = []) {
    if (empty($params['city'])) {
        return 'Не указаны обязательные данные для фильтрации.';
    }

    $default_params = [
        'page' => 1,
        'gifts_on_page' => 6,
        'gift-categories' => []
    ];
    $params = array_merge($default_params, $params);

    $attr = [
        'numberposts' => -1,
        'orderby'     => 'date',
        'order'       => 'ASC',
        'post_type'   => 'gift',
        'gift-categories' => $params['gift-categories'],
        'meta_query' => [
            'relation' => 'AND',
            [
                'key' => 'children_city',
                'value' => $params['city']
            ],
        ],
        'suppress_filters' => true,
    ];

    if (!empty($params['material'])) {
        $attr['meta_query'][] = [
            'key' => 'material',
            'value' => 1
        ];
    }

    if (!empty($params['no_material'])) {
        $attr['meta_query'][] = [
            'key' => 'material',
            'value' => 0
        ];
    }

    if (!empty($params['booked']) && empty($params['all'])) {
        $attr['meta_query'][] = [
            'key' => 'order_is_ordered',
            'value' => 1
        ];
    }

    if (!empty($params['free']) && empty($params['all'])) {
        $attr['meta_query'][] = [
            'key' => 'order_is_ordered',
            'value' => 0
        ];
    }

    $giftPosts = get_posts($attr);
    $count_gifts = count($giftPosts);
    
    $offset = 0;
    $last_gift = $count_gifts;

    if ($params['gifts_on_page'] != -1) {
        $offset      = $params['gifts_on_page'] * $params['page'] - $params['gifts_on_page'];  
        $last_gift   = $count_gifts < $offset + $params['gifts_on_page'] ? $count_gifts : $offset + $params['gifts_on_page'];
    }

    $gifts = [
        'pagination' => [
            'page' => $params['page'],
            'pages' => ceil($count_gifts / $params['gifts_on_page']),
        ],
        'items' => [],
        'count_items' => $count_gifts
    ];

    if ($giftPosts) {
        for ($i = $offset; $i < $last_gift; $i++) { 
            $gifts['items'][] = [
                'id'       => $giftPosts[$i]->ID,
                'children' => get_field('children', $giftPosts[$i]->ID),
                'text'     => get_field('text', $giftPosts[$i]->ID),
                'order'    => get_field('order', $giftPosts[$i]->ID),
            ];
        }
    } 

    return $gifts;
}

function getAllCategories()
{
    return get_terms('gift-categories');
}

function num2word($n, $titles) {
    $cases = array(2, 0, 1, 1, 1, 2);
    return $titles[($n % 100 > 4 && $n % 100 < 20) ? 2 : $cases[min($n % 10, 5)]];
}


/**
 * Count pending posts.
 */
function wph_pending_posts_indicator($menu) {
    $post_types = get_post_types();
    if(empty($post_types)) {return;}
 
	foreach ($post_types as $type) {
        $status        = 'pending';
        $num_posts     = wp_count_posts($type, 'readable');
        $pending_count = 0;
 
        if(!empty($num_posts->$status)) {
            $pending_count = $num_posts->$status;
        }
 
        if ($type == 'post') {
            $menu_str = 'edit.php';
        } else {
            $menu_str = 'edit.php?post_type='.$type;
        }
 
        foreach ($menu as $menu_key => $menu_data) {
            if ($menu_str != $menu_data[2]) {
                continue;
            } else {
                $menu[$menu_key][0] .= " <span class='update-plugins count-$pending_count'>
                <span class='plugin-count'>" . number_format_i18n($pending_count) . '</span></span>';
            }
        }
    }
    return $menu;
}
add_filter('add_menu_classes', 'wph_pending_posts_indicator');

function my_admin_style() {
    wp_enqueue_style('admin-styles', get_stylesheet_directory_uri().'/assets/css/admin.css');
}
add_action('admin_enqueue_scripts', 'my_admin_style');

// Добавляем колонки
add_filter( 'manage_'.'gift'.'_posts_columns', 'add_gift_column', 10, 1 );
function add_gift_column( $columns ){
    //unset($columns['title']);
    unset($columns['date']);

	$my_columns = [
        'name'       => 'Имя ребенка',
        'age'        => 'Возраст',
        'city'       => 'Муниципальное образование',
        'is_ordered' => 'Забронирован',
        'date'       => 'Дата'
    ] ;
 
    $my_columns = array_merge($columns, $my_columns);

	return $my_columns;
}

// Заполняем колонку данными
add_action('manage_'.'gift'.'_posts_custom_column', 'fill_gift_column', 20, 2 );
function fill_gift_column($colname, $post_id ) {
    switch ( $colname ) {
		case 'name': {
			$out = get_post_meta($post_id, 'children_name', 1);
 			break;
		}

        case 'age': {
			$out = get_post_meta($post_id, 'children_age', 1);
 			break;
		}

        case 'city': {
			$city_id = get_post_meta($post_id, 'children_city', 1);
            $out = get_post($city_id)->post_title;
 			break;
		}

        case 'is_ordered': {
			$out = get_post_meta($post_id, 'order_is_ordered', 1) ? 'Да' : 'Нет';
 			break;
		}
	}

    if (isset($out)) {
        echo $out;
    }
}

// фильтр - добавим выпадающий список
add_action( 'restrict_manage_posts', 'add_gift_table_filters');
// Фильтрация: обработка запроса
add_action( 'pre_get_posts', 'add_gift_table_filters_handler' );

function add_gift_table_filters( $post_type ){

    $cs = function_exists('get_current_screen') ? get_current_screen() : null;
    if( ! is_admin() || empty($cs->post_type) || $cs->post_type != 'gift' || $cs->id != 'edit-gift' )
    return;

    global $allCities;
    $cities = $allCities;

    if (empty($cities)) {
        return;
    }

    ob_start();?>
        <select name="cities">
            <option value="-1">Все муниципальные образования</option>
            <?php foreach($cities as $city) : ?>
                <option value="<?= $city['id'] ?>" <?= $_GET['cities'] == $city['id'] ? 'selected' : ''?>>
                    <?= $city['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <select name="is_ordered">
            <option value="-1">Забронированы?</option>
            <option value="true" <?= $_GET['is_ordered'] == 'true' ? 'selected' : ''?>>Да</option>
            <option value="false" <?= $_GET['is_ordered'] == 'false' ? 'selected' : ''?>>Нет</option>
        </select>
    <? $template = ob_get_clean();

	echo $template;
}

function add_gift_table_filters_handler( $query ){

	$cs = function_exists('get_current_screen') ? get_current_screen() : null;

	if( ! is_admin() || empty($cs->post_type) || $cs->post_type != 'gift' || $cs->id != 'edit-gift' )
		return;

    if (!empty($_GET['cities'])) {
        if( @ $_GET['cities'] != -1 ){
            $selected_id = @ $_GET['cities'] ?: '';
            $query->set( 'meta_query', array([ 'key'=>'children_city', 'value'=>$selected_id ]) );
        }
    }

    if (!empty($_GET['is_ordered'])) {
        if( @ $_GET['is_ordered'] != -1 ){
            $selected_id = @ $_GET['is_ordered'] == 'true' ? 1 : 0 ;
            $query->set( 'meta_query', array([ 'key'=>'order_is_ordered', 'value'=>$selected_id ]) );
        }
    }

}

add_action( 'save_post_gift', 'set_title_gifts' ); 
function set_title_gifts($post_id)
{
    remove_action( 'save_post_gift', 'set_title_gifts' );

    wp_update_post( array( 
        'ID'         => $post_id, 
        'post_title' => 'Подарок №' . $post_id,
        'post_name'  => $post_id,
    ) );
    
    add_action( 'save_post_gift', 'set_title_gifts' );
}