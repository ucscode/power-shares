<?php

### start session;

session_start();


### get root directory;

define("MAIN_DIR", str_replace("\\", "/", realpath( __dir__ . '/../' )));


### require database and basic definition;

require __dir__ . "/db.php";
require __dir__ . "/include/define.php";


### get all the class files;

foreach( (new FilesystemIterator( __dir__ . '/classes' )) as $iter ) {
	require_once $iter->getPathname();
};


### require PHPMailer to be use in any script at any time

require_once __include_path . '/PHPMailer/PHPMailer.php';
require_once __include_path . '/PHPMailer/Exception.php';
require_once __include_path . '/PHPMailer/SMTP.php';


### require QRCode library

require_once __include_path . '/phpqrcode/qrlib.php';


### get site default settings;

require __include_path . '/settings.php';




