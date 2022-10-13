<?php 

define('__include_path', __dir__ );

define('__admin_dir', MAIN_DIR . '/admin' );
define('__users_dir', MAIN_DIR . '/users' );
define('__config_dir', MAIN_DIR . '/config' );

define('__json_dir', __include_path . '/JSON' );

define('__core_dir', __config_dir . '/core' );
define('__core_vendors', __core_dir . '/vendors' );
define('__core_views', __core_dir . '/views' );

define('__users_contents', __users_dir . '/dashboard' );
define('__admin_contents', __admin_dir . '/panel' );

define('__auth_dir', __users_dir);

define('__users_login_page', __auth_dir . '/index.php');
define('__users_register_page', __auth_dir . '/signup.php');
define('__users_reset_password_page', __auth_dir . '/reset.php');

