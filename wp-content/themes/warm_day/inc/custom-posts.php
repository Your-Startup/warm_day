<?php
add_action( 'init', 'create_taxonomy' );
function create_taxonomy() {
	register_taxonomy( 'gift-categories', [ 'gift' ], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => 'Категории подарков',
			'singular_name'     => 'Категория подарка',
			'search_items'      => 'Поиск категории',
			'all_items'         => 'Все категории',
			'view_item '        => 'Показать категорию',
			'parent_item'       => 'Родительская категория',
			'parent_item_colon' => 'Родительские категории:',
			'edit_item'         => 'Редактировать категорию',
			'update_item'       => 'Обновить категорию',
			'add_new_item'      => 'Создать категорию',
			'new_item_name'     => 'Новая категория',
			'menu_name'         => 'Категории',
			'back_to_items'     => '← Назад к категориям',
		],
		'description'           => '', // описание таксономии
		'public'                => true,
		'hierarchical'          => true,

		'rewrite'               => true,
		'capabilities'          => array(),
		'meta_box_cb'           => null, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
		'show_admin_column'     => false, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
		'show_in_rest'          => null, // добавить в REST API
		'rest_base'             => null, // $taxonomy
	] );
}

add_action( 'init', 'register_post_types' );
function register_post_types() {

	//Обратная связь
	register_post_type( 'request', [
		'label'  => null,
		'labels' => [
			'name'               => 'Заявки', // основное название для типа записи
			'singular_name'      => 'Заявка', // название для одной записи этого типа
			'add_new'            => 'Создать заявку', // для добавления новой записи
			'add_new_item'       => 'Создание заявки', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактирование заявки', // для редактирования типа записи
			'new_item'           => 'Заявка', // текст новой записи
			'view_item'          => 'Смотреть заявку', // для просмотра записи этого типа.
			'search_items'       => 'Искать заявку', // для поиска по этим типам записи
			'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => 'Обратная связь', // название меню
		],
		'description'         => '',
		'public'              => true,
		'show_in_menu'        => true, // показывать ли в меню адмнки
		// 'show_in_admin_bar'   => null, // зависит от show_in_menu
		'show_in_rest'        => null, // добавить в REST API. C WP 4.7
		'rest_base'           => null, // $post_type. C WP 4.7
		'menu_position'       => 27,
		'menu_icon'           => 'dashicons-bell',
		'hierarchical'        => false,
		'supports'            => [ 'title', 'custom-fields' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		'taxonomies'          => [],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	] );

	// Подарки
	register_post_type( 'gift', [
		'label'  => null,
		'labels' => [
			'name'               => 'Подарки', // основное название для типа записи
			'singular_name'      => 'Подарок', // название для одной записи этого типа
			'add_new'            => 'Создать подарок', // для добавления новой записи
			'add_new_item'       => 'Создание подарка', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактирование подарка', // для редактирования типа записи
			'new_item'           => 'Подарок', // текст новой записи
			'view_item'          => 'Смотреть подарок', // для просмотра записи этого типа.
			'search_items'       => 'Искать подарок', // для поиска по этим типам записи
			'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => 'Подарки', // название меню
		],
		'description'         => '',
		'public'              => true,
		'show_in_menu'        => true, // показывать ли в меню адмнки
		'show_in_rest'        => null, // добавить в REST API. C WP 4.7
		'rest_base'           => null, // $post_type. C WP 4.7
		'menu_position'       => 28,
		'menu_icon'           => 'dashicons-star-filled',
		'hierarchical'        => false,
		'supports'            => ['title', 'custom-fields' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		'taxonomies'          => ['gift-categories'],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	] );

	// Муниципальные образования
	register_post_type( 'city', [
		'label'  => null,
		'labels' => [
			'name'               => 'Муниципальные образования', // основное название для типа записи
			'singular_name'      => 'Муниципальное образование', // название для одной записи этого типа
			'add_new'            => 'Создать муниципальное образование', // для добавления новой записи
			'add_new_item'       => 'Создание муниципального образования', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактирование муниципального образования', // для редактирования типа записи
			'new_item'           => 'Муниципальное образование', // текст новой записи
			'view_item'          => 'Смотреть муниципальное образование', // для просмотра записи этого типа.
			'search_items'       => 'Искать муниципальное образование', // для поиска по этим типам записи
			'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => 'Муниципальные образования', // название меню
		],
		'description'         => '',
		'public'              => true,
		'show_in_menu'        => true, // показывать ли в меню адмнки
		'show_in_rest'        => null, // добавить в REST API. C WP 4.7
		'rest_base'           => null, // $post_type. C WP 4.7
		'menu_position'       => 29,
		'menu_icon'           => 'dashicons-location-alt',
		'hierarchical'        => false,
		'supports'            => ['title', 'thumbnail', 'custom-fields'], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		'taxonomies'          => [],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	] );
}

// Страница доп. настроек
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title'    => 'Дополнительные настройки',
        'menu_title'    => 'Доп. настройки',
        'menu_slug'     => 'additional-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
}