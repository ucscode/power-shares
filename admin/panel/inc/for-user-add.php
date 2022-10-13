<?php

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	
	$_POST = sysfunc::sanitize_input($_POST);
	
	$alert = !empty($_POST['alert']);
	unset($_POST['alert']);
	
	foreach( ['username', 'email'] as $key ) {
		$user = sysfunc::_data( 'users', $_POST[$key], $key );
		if( $user ) {
			$temp->status = !($temp->msg = ucfirst("{$key} already exists") );
			break;
		}
	}
	
	if( empty($temp->msg) ) {
		
		$_POST['refcode'] = strtolower(sysfunc::keygen(6));
		$_PW = $_POST['password'];
		$_POST['password'] = sysfunc::encpass($_POST['password']);
		
		$SQL = sQuery::insert( 'users', $_POST );
		$temp->status = $link->query( $SQL );
		
		if( $temp->status ) {
			
			$temp->msg = "New user added successfully";
			
			## -----
			
			if( $alert ) {
				
				$mail = sysfunc::initMail();
				
				$mail->addAddress($_POST['email']);
				$mail->Subject = "New Account Created";
				
				$sitename = $config->get('site_name');
				
				$credentials = (new email_handler())->table_context(array(
					"Username" => $_POST['username'],
					"Password" => $_PW,
					"Referrer Code" => $_POST['refcode']
				));
				
				$mail->Body = (new email_handler())->message( "
					<div>
						This is to inform you that a new account has just been created for you on {$sitename} <br>
						Your login details are given below:
					</div>
					<div>
						{$credentials}
					</div>
				" );
				
				($mail->send());
		
			}
			
		} else $temp->msg = "User was not added";
	
	};
	
};