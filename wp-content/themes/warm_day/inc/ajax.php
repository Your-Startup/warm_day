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