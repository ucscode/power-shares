<?php 

// Define variables and initialize with empty values

$username = $email = $password = $cpassword = $address = $phone = $country = null;
$username_err = $email_err = $password_err = $cpassword_err =  $address_err = $phone_err = $country_err =  null;

// Processing form data when form is submitted

if($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if( !isset($_POST['terms']) ) $temp->msg =  "You have to accept terms and condition!";

    else {
		
		$db_values = array();
		
		### sanitize every input in $_POST
		$_POST = sysfunc::sanitize_input($_POST);
		
		### 
		function confirm_uniqueness($key, ?string $label = null, &$var) {
			global $link, $db_values;
			if( is_null($label) ) $label = $key;
			if( empty($_POST[$key]) ) return "Please enter a {$label}";
			else {
				$sql = "SELECT id FROM users WHERE {$key} = '" . $_POST[$key] . "'";
				$exists = $link->query($sql)->num_rows;
				if( $exists ) return "The {$label} is already taken";
				$var = $db_values[$key] = $_POST[$key];
			};
		};
		
		### verify username;
		$username_err = confirm_uniqueness('username', null, $username);
		
		### verify email;
		$email_err = confirm_uniqueness('email', null, $email);
		
		
		### validate password;
		if(empty($_POST["password"])) $password_err = "Please enter a password.";     
		else if(strlen($_POST["password"]) < 5) $password_err = "Password must have atleast 5 characters.";
		else $password = $db_values['password'] = sysfunc::encpass($_POST["password"]);
		
		
		### validate confirm password
		if(empty($_POST["cpassword"])) $cpassword_err = "Please confirm password.";     
		else if(empty($password_err) && ($password != sysfunc::encpass($_POST['cpassword']))) $cpassword_err = "Password did not match.";
		
		
		// Check input errors before inserting in database
		$is_valid = ( !$username_err && !$email_err && !$password_err && !$cpassword_err );
		
		if( $is_valid ) {
		
			foreach(['phone', 'country', 'address', 'referrer'] as $key) {
				$db_values[$key] = $_POST[$key];
			};
			
			$bonus = $config->get('registration_bonus');
			if( is_numeric($bonus) ) $db_values['walletbalance'] = $bonus;
			
			$db_values['token'] = sysfunc::keygen(6);
			$db_values['refcode'] = strtolower(sysfunc::keygen(6));
			
			$SQL = sQuery::insert( 'users', $db_values );
			
			$inserted = $link->query( $SQL );
			
			if( $inserted ) {
				
				$confirm_link = sysfunc::url( __users_login_page ) . "?v={$db_values['token']}";
				$platform = $config->get('site_name');
				
				$contact_email = $config->get('contact_email');
				if( empty($contact_email) ) $contact_email = 'anytime';
				
				$temp->mailMsg = "
					<p>Hello {$db_values['username']},</p>
					<p>Thank you for joining {$platform}.</p>
					<p>This email confirms that your account was created successfully. To verify this email, click the link below.</p>
					<p><a href='{$confirm_link}'>Click here to verify</a></p>
					<p>If you experience any issues logging into your account, reach out to us at {$contact_email}</p>
					<p>Best Regard, <br> The {$platform} team</p>
				";
				
				$eh = (new email_handler())->setTitle( "Thank you for registering on " . $config->get('site_name') );
				
				$mail = sysfunc::initMail();
				$mail->addAddress($email);
				
				$mail->Subject = "Email Verification";
				$mail->Body = $eh->message( $temp->mailMsg );
				
				if(!$mail->send()) $temp->msg = "Mailer Error: " . $mail->ErrorInfo;
				else $temp->msg =  "Registration Successful! <br> We have sent a message to your Email";
				
			} else $temp->msg = "Registration Failed! <br> Please try again";
			
		};

	}

}