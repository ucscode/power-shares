<?php

define('ignore_login_check', true);

require __dir__ . '/sub-config.php';

session_destroy(); //destroy the session
	
header("location:" . sysfunc::url( __users_login_page ));

exit();

