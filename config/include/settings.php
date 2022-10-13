<?php 

$config = new pairs($link, 'config');

$usermeta = new pairs($link, 'usermeta');


### Init Menufy;

$menufy = new Menufy();


### Sections [ view class ];

require __core_views . '/section.php';


### Temporary store data for processing;

$temp = new stdClass();

$temp->logo = sysfunc::url( __admin_contents . '/logo/' . (!empty($config->get('logo')) ? $config->get('logo') : 'logo.png') );

$temp->title = $config->get('site_name');

$temp->msg = null;


### Avoid access to admin panel

if( defined("ADMIN_ONLY") ) {

	$temp->admin = (new user('admin'))->info();

	if( !$temp->admin ):
		header("location:" . sysfunc::url( __admin_dir ));
		exit;
	endif;
	
};


### global executables

require __include_path . '/executables.php';