<?php

add_action('admin_menu', 'register_export_gifts_submenu_page');

function register_export_gifts_submenu_page() {
	add_submenu_page(
		'edit.php?post_type=gift',
		'Экспорт подарков',
		'Экспорт подарков',
		'manage_options',
		'export-gifts',
		'export_gifts_callback'
	);
}

function export_gifts_callback() {

    $gifts = get_posts( [     
        'numberposts' => -1,
        'post_type'   => 'gift',
        'meta_query' => [
            'relation' => 'AND',
            [
                'key' => 'order_is_ordered',
                'value' => 1
            ],
        ],
        'suppress_filters' => true,
    ] ); 

    $count = count($gifts);

    ob_start();
	include_once(get_template_directory().'/template-parts/admin/export-gifts.php');
	$template = ob_get_clean();

    echo $template; 
}

add_action('wp_ajax_export_gifts', 'exportGifts');

function exportGifts() {

    $params = [
        'relation' => 'AND',
        [
            'key' => 'order_is_ordered',
            'value' => 1
        ],
    ];

    $is_exel = $_POST['format'] == 'exel';
    $format = $is_exel ? '(для Exel)' : '(для Google таблиц)';

    $city = isset($_POST['city']) ? $_POST['city'] : false;
    $cityName = '';
    if ($city) {
        $cityPost = get_post($city);
        $cityName = ' (' . $cityPost->post_title . ')';
        $params[] = [
            'key' => 'children_city',
            'value' => $city
        ];
    }

    $fileName = "Выгрузка забронированных подарков от " . wp_date('d.m.Y H:i:s') . $cityName  . ' ' . $format . ".csv";
    $file     = get_template_directory() . "/temp/" . $fileName; 

    $giftPosts = get_posts( [     
        'numberposts' => -1,
        'post_type'   => 'gift',
        'meta_query' => $params,
        'suppress_filters' => true,
    ] );
    
    $gifts = [];
    if ($giftPosts) {
        foreach ($giftPosts as $giftPost) { 
            $gifts[] = [
                'id'       => $giftPost->ID,
                'children' => get_field('children', $giftPost->ID),
                'text'     => get_field('text', $giftPost->ID),
                'order'    => get_field('order', $giftPost->ID),
            ];
        }
    } 

    $records = [ 
        ['№ подарка', 'Имя ребенка', 'Описание подарка', 'ФИО дарителя', 'Телефон', 'Email']
    ];

    if (!empty($gifts)) {
        foreach ($gifts as $gift) { 
            $records[] = [
                $gift['id'],
                $gift['children']['name'],
                $gift['text'],
                $gift['order']['name'],
                $gift['order']['phone'],
                $gift['order']['email'],
            ];
        }
    }

    $data = '';

    foreach($records as $row) {
        $str = strip_tags(implode("; ", $row));
        $str = str_replace(array("\r\n", "\r", "\n"), ' ', $str);
        $data .= $str . "\n";
    }

    if ($is_exel) {
        $data = mb_convert_encoding($data, "windows-1251", "utf-8");
    }
    
    file_put_contents($file, $data);

    $result = [
        'name' => $fileName,
        'link' => get_template_directory_uri() . "/temp/" .  $fileName
    ];

    echo json_encode($result);
    exit;
}
