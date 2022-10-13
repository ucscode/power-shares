<?php 

define("ADMIN_ONLY", TRUE);

require_once realpath( __dir__ . '/../../' ) . '/config/config.php';

define( "PANEL_DIR", __DIR__ );

$msg = "";

events::addListener('@header', function() { ?>
	<link rel='stylesheet' href='<?php echo sysfunc::url( PANEL_DIR . '/extension/style.css' ); ?>'>
<?php });

if( empty($_SESSION['admin:alert']) ) require_once __DIR__ . '/extension/notifications.php';

$USER_OFF = 'DELETED';
