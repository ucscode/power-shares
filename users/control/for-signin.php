<?php

$email_err = $password_err = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	### verify email;
	if (empty($_POST["email"])) $email_err = "Email is required";
	else {
		$email = sysfunc::sanitize_input($_POST["email"], true);
		// check if e-mail address is well-formed
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $email_err = "Invalid email format"; 
	};
	
	### verify password;
	if (empty($_POST["password"])) $password_err = "Password is required";
	else $password = sysfunc::sanitize_input($_POST["password"]);
    
	### get ip address;
	$ip = $_SERVER['REMOTE_ADDR'];
	
	
	if( $email_err || $password_err ) $temp->msg = "Email or Password fields cannot be empty!";
	
	else {
		
		if( defined("admin_login_panel") && isset($temp->admin_login) ) {
			
			### Login As Admin
			
			($temp->admin_login)();
			
		} else {
				
			### Login As Member 
			
			$password = sysfunc::encpass($password);
			
			$result = $link->query("
				SELECT * FROM users 
				WHERE email='$email' AND password= '$password'
			");
			
			if( $result->num_rows ) {
				
				$__user = $result->fetch_assoc();
				
				if( empty($__user['confirm']) ) $temp->msg = "Please wait for administrator's approval on your account for activation!";
					
				else {
						 
					if( !empty($__user['2fa']) ){
						
						header("location:" . sysfunc::url( __users_contents . "/login.php?email=$email") );
						die;
						
					} else {
						
						### save user data in session;
						
						$_SESSION['users:email'] = $email;
						$_SESSION['users:password'] = $password;
						
						$date = date("Y/m/d");
						
						header("location:" . sysfunc::url( __users_contents . "/index.php"));
						
						### send Email;
						$mail = sysfunc::initMail();
						$mail->addAddress($__user['email'], $__user['username']);
						$mail->Subject = "Account Details";
						
						$temp->mailMsg = "
							Your account was logged in from (IP: {$ip}) on " . date("F j, Y, g:i a") .". <br>
							If you did not login from this device, contact your account manager to secure your account.
						";

						$mail->Body = (new email_handler())->message( trim($temp->mailMsg), $__user['username'] );
						
						if($mail->send()) $temp->msg =  "Message has been sent successfully!";
						else $temp->msg = "Something went wrong. Please try again later!";
						
						exit;
						
						// endpoint;
					};
				};
				  
			} else $temp->msg = "Email or Password incorrect!";
		
		}; // Login as Member;
			
	}
		
} else {
	
	if( $_GET['v'] ?? null ) {
		
		$client = sysfunc::_data( 'users', $_GET['v'], 'token' );
		if( !$client ) $temp->msg = 'Invalid email confirmation link';
		else if( !$client['confirm'] ) {
			$SQL = sQuery::update( 'users', array(
				"confirm" => 1,
				"token" => null
			), "id = {$client['id']}");
			$temp->status = $link->query( $SQL );
			$temp->msg = ($temp->status) ? "Your email has been confirmed" : "Email confirmation failed";
		};
		
	}
	
}
			 
		
		
	
	



