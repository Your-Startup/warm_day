<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать файл в "wp-config.php"
 * и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки базы данных
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры базы данных: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'omc89_wd' );

/** Имя пользователя базы данных */
define( 'DB_USER', 'omc89_wd' );

/** Пароль к базе данных */
define( 'DB_PASSWORD', 'BLp*&V4x' );

/** Имя сервера базы данных */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу. Можно сгенерировать их с помощью
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}.
 *
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными.
 * Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '/ROI+{:_siA=N1dI<hz@u*ROhV1kokFK0)oA#N]4pC,B/r?w}EE[kW+ 8L>KpYe=' );
define( 'SECURE_AUTH_KEY',  '8E/e+22^E{jvwps 0|(Ji{Y0isA!XXB?,Y[z;7wx<G6}4s{90U,@xJtdD}e}nZ%B' );
define( 'LOGGED_IN_KEY',    'a i5e+X{EjX<,JL@N0X0WS1RDSGX3h8ruK962Y?]/&;UD&oy1y,j[u(9|o<ACpqd' );
define( 'NONCE_KEY',        ' cp<2{HS([)$aJ5~2r;?RZ+cz4_}Z^S/.2G4Qt[eY92|*4lZ43/}/B#X{K8NtUIs' );
define( 'AUTH_SALT',        'jL(AM?&gVE7@Of0iRbcgm2?{~UfNVIHFzTti7y)+|&sna1o<845yzMR.co`QP#&@' );
define( 'SECURE_AUTH_SALT', '>m7]t@nQKZ~6U&lDR$)c(m@T0CT_>agCMt~^h3guVI]4bO=%ZxO-%@4^t!(@:=Y-' );
define( 'LOGGED_IN_SALT',   '[nZmH~,r3u~{a(QrE3=4ecA,txs)^rx>F*q-3:6Jcl`f!tURVV1*-<h6)LaxY_ m' );
define( 'NONCE_SALT',       'm;Kbhv<`yZ-bxUT:`o&+e~!X^vJ:#?8%BOATaZ<ezdmw}TEPFESThc,Jzma6 d]/' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_DEBUG_LOG', true );

/* Произвольные значения добавляйте между этой строкой и надписью "дальше не редактируем". */



/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
