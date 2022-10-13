<?php 

### admin panel identity;

define('admin_login_panel', true);


### success login function for admin;

$temp->admin_login = (function() {
	
	global $link, $temp;
	
	$password = sysfunc::encpass($_POST['password']);
	
	$sql = "
		SELECT * FROM admin 
		WHERE email = '{$_POST['email']}' AND password = '{$password}'
	";
	
	$admin = $link->query($sql)->fetch_assoc();
	
	if( !$admin ) return $temp->msg = "Email or Password is incorrect";
	
	$_SESSION['admin:email'] = $admin['email'];
	$_SESSION['admin:password'] = $admin['password'];
	
	header( "location:" . sysfunc::url( __admin_contents ) );
	
	exit;
	
});


### borrow login file

require_once __auth_dir . '/control/for-signin.php';

	

