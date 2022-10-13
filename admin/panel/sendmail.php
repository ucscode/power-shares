<?php

require __dir__ . '/sub-config.php';
  

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	$mssg = call_user_func(function() use($link) {
		
		foreach( $_POST as $key => $value ) {
			$value = sysfunc::sanitize_input($value);
			$_POST[$key] = $value;
			if( empty($value) ) return ["All fields are required", 0];
		};
		
		$emails = array_map('trim', explode(",", $_POST['emails']));
		$mail = sysfunc::initMail();
		
		foreach( $emails as $addr ) {
			if( !filter_var($addr, FILTER_VALIDATE_EMAIL) ) return ["Invalid email address - ($addr)", 0];
			$mail->addAddress($addr);
		};
		
		$mail->Subject = $_POST['subject'];
		$mail->Body = (new email_handler())->message( nl2br($_POST['message']) );
		
		$send = $mail->send();
		return [ $send ? "Email successfully sent" : "Email sending failed", $send ];
		
		
	});
	
	if( $mssg[1] ) $_POST = sysfunc::clear_input($_POST);

}





include 'header.php';

?>

	<?php section::title( "Send Mail", false ); ?>

   <div class="card">
        <div class="card-body">
			
			<?php sysfunc::html_notice( $mssg[0] ?? null, $mssg[1] ?? null ); ?>
			
			<form class="form-horizontal" action="sendmail.php" method="POST" >
				<div class="form-group">
					<input type="text" name="emails" placeholder="Emails (seperated by comma)"  class="form-control" value="<?php echo $_POST['emails'] ?? null; ?>" required>
				</div>
				<div class="form-group">
					<input type="text" name="subject" placeholder="Email Subject" class="form-control" required value="<?php echo $_POST['subject'] ?? null; ?>">
				</div>
				<div class="form-group">
					<textarea  name="message" placeholder="Write your mail here"  class="form-control" required rows="9"><?php echo $_POST['message'] ?? null; ?></textarea>
				</div>
				<button style="" type="submit" class="btn btn-primary"> 
					<i class="fas fa-paper-plane"></i>&nbsp; Send Mail 
				</button>
			</form>

		</div>    
	</div>


<?php include 'footer.php'; ?>