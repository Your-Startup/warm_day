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

	sendMail('feedback', $data);

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

	$giftData = get_fields($gift->ID);

	if ($giftData['order']['is_ordered']) {
		$result = [
			'success' => false,
			'message' => getAnswerTemplate('Подарок уже забронирован.'),
		];
		echo json_encode($result);
		wp_die();
	}

	$attachment_id = media_handle_upload( 'logo_company', $gift->ID );

	if ( is_wp_error( $attachment_id ) ) {
		$attachment_id = '';
	}

	$new_order = [
		'is_ordered'   => true,
		'name'         => $data['name'],
		'is_show'      => isset($data['is_show']),
		'logo_company' => $attachment_id,
		'company'      => isset($data['company']) ? $data['company'] : '',
		'phone'        => $data['phone'],
		'email'        => $data['email'],
	];

	update_field('order', $new_order, $gift->ID);

	$giftData['id'] = $gift->ID;
	$giftData['order'] = $new_order;

	sendMail('order_admin', $giftData);
	sendMail('order_instructions', $giftData);
	sendMail('order_gratitude', $giftData);

	$title = 'Спасибо, ' . $new_order['name'] . '!';
	$text  = 'Вам на почту отправлены письмо с инструкцией и письмо-благоданость, a Ваше имя' . ($new_order['is_show'] ? ' ' : ' не ') . 'будет указано на подарке.';

	$result = [
		'success' => true,
		'message' => getAnswerTemplate($title, $text, true),
	];

    echo json_encode($result);
    wp_die();
}

function getAnswerTemplate($title = '', $text = '', $is_order = false) {
	ob_start();
	include_once(get_template_directory().'/template-parts/components/answer.php');
	$template = ob_get_clean();

	return $template;
}

function sendMail($type, $data) {
	switch ($type) {
		case 'feedback':
			$to      = get_option('admin_email');
			$subject = 'Запрос на обратную связь ' . wp_date('d.m.Y H:i:s');
			$message = 'Имя: ' . $data['name'] . "\n" . 
					   'Телефон: ' . $data['phone'] . "\n" . 
					   'Почта: ' . $data['email'];
			$headers = [
				'From: Тёплый день <info@тёплыйдень.рф>',
			];
			wp_mail($to, $subject, $message, $headers);
			break;
		
		case 'order_admin':
			$to      = get_option('admin_email');
			$subject = 'Забронирован подарок №' . $data['id'];
			$message = 'Имя: ' . $data['order']['name'] . "\n" . 
					   'Телефон: ' . $data['order']['phone'] . "\n" . 
					   'Почта: ' . $data['order']['email'];
			$headers = [
				'From: Тёплый день <info@тёплыйдень.рф>',
			];
			wp_mail($to, $subject, $message, $headers);
			break;

		case 'order_instructions':
			$to      = $data['order']['email'];
			$subject = 'Инструкция для дарителя';
			ob_start();
			include_once(get_template_directory().'/template-parts/mails/instructions.php');
			$message = ob_get_clean();
			$headers = [
				'From: Тёплый день <info@тёплыйдень.рф>',
				'content-type: text/html'
			];
			wp_mail($to, $subject, $message, $headers);
			break;

		case 'order_gratitude':
			$to      = $data['order']['email'];
			$subject = 'Благодарность';
			ob_start();
			include_once(get_template_directory().'/template-parts/mails/gratitude.php');
			$message = ob_get_clean();
			$headers = [
				'From: Тёплый день <info@тёплыйдень.рф>',
				'content-type: text/html'
			];
			wp_mail($to, $subject, $message, $headers);
			break;
	}
}