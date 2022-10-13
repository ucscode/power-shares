<?php

### CHECK APPROVAL;

if( !empty($_GET['verify']) ) {
	
	$split = explode("-", $_GET['verify']);
	
	$user = sysfunc::_data( 'users', $split[0] );
	
	if( !$user || empty($split[1]) ) $APPROVED = false;
	else {
		$ver_code = $usermeta->get('ver_code', $user['id']);
		$APPROVED = ( $ver_code && $ver_code == $split[1] );
	};

} else $APPROVED = false;


### EXEC POST REQUEST;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
	if( isset($_POST['email']) ) {
			
		if (empty($_POST["email"])) $email_err = "Email is required";
	  
		else {
		  
			$email = sysfunc::sanitize_input($_POST["email"], true);
			
			if( empty($email) )$temp->msg = "email fields cannot be empty!";
			
			else {
				
				$user = sysfunc::_data( 'users', $email, 'email' );

				if( $user ) {
					
					$mail = sysfunc::initMail();
					$mail->addAddress($email);
					$mail->Subject = "Password Reset";
					
					$ver_code = sysfunc::keygen(10);
					$ver_url = sysfunc::url( __users_reset_password_page ) . "?verify={$user['id']}-{$ver_code}";
					$usermeta->set('ver_code', $ver_code, $user['id']);
					
					$temp->mailMsg = "
						<h4>Hi {$user['username']}</h4>
						<p>A new request has been sent to reset your account password. If this was you, then click on the link below to reset your password</p>
						<a href='{$ver_url}'>Click here to reset password</a>
					";
					
					$mail->Body = (new email_handler())->message( $temp->mailMsg );
					
					if(!$mail->send()) $temp->msg = "Mailer Error: " . $mail->ErrorInfo;
					else $temp->msg =  "Check Your Email and follow the link to reset your password";
					
				} else $temp->msg = "Something went wrong! <br> Request could not be handled";
				
			}
			
		};
		
	} else {
		
		if( strlen($_POST['password']) < 5 ) $temp->msg = "Password must be at least 5 characters";
		
		else if( $_POST['password'] != $_POST['confirm-password'] ) $temp->msg = "Password does not match";
		
		else {
			
			$SQL = sQuery::update( "users", [
				'password' => sysfunc::encpass( sysfunc::sanitize_input($_POST['password'], true) )
			], "id = {$user['id']}" );
			
			$temp->status = $link->query( $SQL );
			
			if( $temp->status ) {
				
				$APPROVED = !($temp->msg = "Password reset was successful <br> You can login with your new password");
				$usermeta->remove( 'ver_code', $user['id'] );
			
			} else $temp->status = !($temp->msg = 'Password reset failed! <br> Please try again');
			
		}
		
	};
	
};

