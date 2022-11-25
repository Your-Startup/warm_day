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
    echo json_encode($_POST);
    wp_die();
}

add_action('wp_ajax_feedback'       , 'feedback');
add_action('wp_ajax_nopriv_feedback', 'feedback');

function feedback()
{
	$data = $_POST;

	$feedback_id = wp_insert_post(array(
		'post_title'  => sanitize_text_field( 'Запрос на обратную связь ' . date('d.m.Y H:i:s') ),
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

	$result = [
		'success' => true,
		'message' => 'Спасибо, ' . $data['name'] . '!<br>Ваша заявка отправленна, мы свяжемся с Вами в ближайшее время.'
	];

    echo json_encode($result);
    wp_die();
}