<?php 

require_once realpath( __dir__ . '/../../' ) . '/config/config.php';

define( "PANEL_DIR", __DIR__ );

$__user = (new user())->info();

if( !defined('ignore_login_check') ) {
	if( !$__user ) {
		header("location: " . sysfunc::url( __users_login_page ));
		exit;
	};
};

if( !empty($__user) ) {
	
	### increase investment profit;
	// shares::increment( $__user['id'] );
	
	### update last seen
	$link->query( 
		sQuery::update( 
			'users', 
			array( 'last_seen' => date('Y-m-d H:i:s') ), 
			"id = '{$__user['id']}'" 
		) 
	);
	
	### Check For Ticket Replies
	
	require __DIR__ . '/sections/elems.php';
	
};


