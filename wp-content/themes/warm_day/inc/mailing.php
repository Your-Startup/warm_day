<?php

add_action('admin_menu', 'register_mailing_submenu_page');

function register_mailing_submenu_page() {
	add_submenu_page(
		'edit.php?post_type=gift',
		'Ручная рассылка',
		'Ручная рассылка',
		'manage_options',
		'mailing',
		'mailing_callback'
	);
}

function mailing_callback() {

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
	include_once(get_template_directory().'/template-parts/admin/mailing.php');
	$template = ob_get_clean();

    echo $template; 
}

add_action('wp_ajax_mailing', 'mailing');

function mailing() {

    $params = [
        'relation' => 'AND',
        [
            'key' => 'order_is_ordered',
            'value' => 1
        ],
    ];

    $giftPosts = get_posts( [     
        'numberposts' => -1,
        'post_type'   => 'gift',
        'orderby'     => 'modified',
        'order'       => 'ASC',
        'meta_query' => $params,
        'suppress_filters' => true,
    ] );
    
    $count = count($giftPosts);

    $giftPost = $giftPosts[$_POST['offset']];

    $giftData = get_fields($giftPost->ID);
    $giftData['id'] = $giftPost->ID;

    switch ($_POST['type']) {
        case 'ordered':
            sendOrdered($giftData, $count);
            break;
        
        case 'reminder':
            sendReminder($giftData, $count);
            break;
    }

    exit;
}


function sendOrdered($giftData, $count) {
	$is_send_1 = sendMail('order_instructions', $giftData);
	$is_send_2 = sendMail('order_gratitude', $giftData);

    echo json_encode([
        'max'    => $count,
        'email'  => $giftData['order']['email'] . ($is_send_1 ? ' ОК ' : ' ERROR ') . ($is_send_2 ? ' ОК ' : ' ERROR '),
    ]);
}

function sendReminder($giftData, $count) {
    $is_send = sendMail('reminder', $giftData);

    echo json_encode([
        'max'    => $count,
        'email'  => $giftData['order']['email'] . ($is_send ? ' ОК ' : ' ERROR ')
    ]);
}

