<?php
add_action( 'wp_enqueue_scripts', 'myajax_data', 99 );
function myajax_data(){
	wp_localize_script( 'warm_day-script-base', 'myajax',
		array(
			'url' => admin_url('admin-ajax.php')
		)
	);
}

add_action('wp_ajax_catalog_filter'       , 'catalogFilter');
add_action('wp_ajax_nopriv_catalog_filter', 'catalogFilter');

function catalogFilter()
{
	$result = [
		'success' => false,
		'message' => 'Непредвиденная ошибка.'
	];

	$params = $_POST;

	if (empty($params) && empty($params['city'])) {
		$result['message'] = 'Не указаны обязательные данные для фильтрации.';
		echo json_encode($result);
    	wp_die();
	}

	unset($params['action']);

	$gifts = getGifts($params);
	ob_start();
	include_once(get_template_directory().'/template-parts/components/gifts.php');
	$template = ob_get_clean();

	$result['success']  = true;
	$result['message']  = 'ОК';
	$result['template'] = $template;

    echo json_encode($result);
    wp_die();
}

add_action('wp_ajax_feedback'       , 'feedback');
add_action('wp_ajax_nopriv_feedback', 'feedback');

function feedback()
{
	$data = $_POST;

	if (empty($data) || 
		empty($data['name']) || 
		empty($data['phone']) || 
		empty($data['email'])) 
	{
		$result = [
			'success' => false,
			'message' => getAnswerTemplate('Не указанны обязательные данные для создания заявки.')
		];
		echo json_encode($result);
		wp_die();
	}


	$feedback_id = wp_insert_post(array(
		'post_title'  => sanitize_text_field( 'Запрос на обратную связь ' . wp_date('d.m.Y H:i:s') ),
		'post_status' => 'pending',
		'post_type'   => 'request'
	));

	if( is_wp_error($feedback_id) ){
		$result = [
			'success' => false,
			'message' => $feedback_id->get_error_message()
		];
		echo json_encode($result);
		wp_die();
	}

	foreach ($data as $key => $value) {
		if ($key != 'action') {
			update_field($key, $value, $feedback_id);
		}
	}

	$title = 'Спасибо, ' . $data['name'] . '!';
	$text  = 'Ваша заявка отправленна, мы свяжемся с Вами в ближайшее время.';

	$result = [
		'success' => true,
		'message' => getAnswerTemplate($title, $text),
	];

    echo json_encode($result);
    wp_die();
}


add_action('wp_ajax_order'       , 'order');
add_action('wp_ajax_nopriv_order', 'order');

function order()
{
	$data = $_POST;

	if (empty($data) || 
		empty($data['id']) || 
		empty($data['city']) || 
		empty($data['name']) || 
		empty($data['phone']) || 
		empty($data['email'])) 
	{
		$result = [
			'success' => false,
			'message' => getAnswerTemplate('Не указанны обязательные данные для бронирования.'),
			'data' => $data
		];
		echo json_encode($result);
		wp_die();
	}

	$gift = get_post($data['id']);

	if (!$gift) {
		$result = [
			'success' => false,
			'message' => getAnswerTemplate('Подарок не найден.'),
		];
		echo json_encode($result);
		wp_die();
	}

	$order = get_field('order', $gift->ID);

	if ($order['is_ordered']) {
		$result = [
			'success' => false,
			'message' => getAnswerTemplate('Подарок уже забронирован.'),
		];
		echo json_encode($result);
		wp_die();
	}

	$new_order = [
		'is_ordered' => true,
		'name'       => $data['name'],
		'is_show'    => isset($data['is_show']),
		'company'    => isset($data['company']) ? $data['company'] : '',
		'phone'      => $data['phone'],
		'email'      => $data['email'],
	];

	update_field('order', $new_order, $gift->ID);

	$title = 'Спасибо, ' . $new_order['name'] . '!';
	$text  = 'Вам на почту отправлены писмо с инструкцией и писмо благоданость, a Ваше имя' . ($new_order['is_show'] ? ' ' : ' не ') . 'будет указано на подарке.';

	$result = [
		'success' => true,
		'message' => getAnswerTemplate($title, $text),
	];

    echo json_encode($result);
    wp_die();
}

function getAnswerTemplate($title = '', $text = '') {
	ob_start();
	include_once(get_template_directory().'/template-parts/components/answer.php');
	$template = ob_get_clean();

	return $template;
}