<?php

define('ignore_login_check', true);

require_once __dir__ . '/sub-config.php';

require_once __include_path . '/PHPGangsta/GoogleAuthenticator.php';

$msg = "";

$ga = new PHPGangsta_GoogleAuthenticator();

### GA Settings;

	$secret = $ga->createSecret();

	$qr = $ga->getQRCodeGoogleUrl($settings['name'], $secret);

	$myCode = $ga->getCode($secret);

	$result = $ga->verifyCode($secret, $myCode, 3);


$email= $__user['email'];


### Handle Post Request;

if(isset($_POST['submit'])){

	$sql1= "SELECT * FROM tfa WHERE email = '$email'";
	
	$result1 = mysqli_query($link,$sql1);

	if(mysqli_num_rows($result1)) $row = mysqli_fetch_assoc($result1);

	if(isset($row['result']) && !empty($row['result'])) {
		
		$reactivate = $link->query( "UPDATE users SET `2fa` = 1 WHERE email = '{$email}'" );
		
		$msg = $reactivate ? "2FA Already activated!" : "Unable to confirm 2FA activation";
	
	} else {
		   
		$email= $_POST['email'];
		$secret = $_POST['secret'];
		$qrcode = $_POST['qrcode'];
		$result = $_POST['result'];

		$sql= "INSERT INTO tfa (email,secret,qrcode,result) VALUES ('$email','$secret','$qrcode','$result')";

		if ($link->query($sql) === TRUE) {

			$sql1 = "UPDATE users SET `2fa` = '1' WHERE email = '{$email}'";

			mysqli_query($link, $sql);
			
			$msg = " You have successfully activated google authenticator security down 2fa app from playstore";
			
		} else {
			$msg = " Error activating google authenticator";
		};
		
	}
}

include "header.php";

?>

  <div class="card">
  
	<div class="card-header">
		<h2 class='text-center' >
			<b>GOOGLE AUTHENTICATOR</b>
		</h2>
	</div>
	
	<div class='card-body'>
	
		<h5 align="center" >
			<b>Make sure you scan the Qr code and authenticate your email before logging out else click Deactivate 2fa</b>
		</h5>
	
		<?php sysfunc::html_notice( $msg ?? null ); ?>
		
		</br>
	  
		<div class="text-center">
			
			<img src="<?php echo $qr; ?>" class='mb-4'>

			<div>
				<form action="generate.php" method="POST">

					<input class='form-control' type="email" name="email" placeholder="Enter your email" value="<?php echo $email; ?>">
					<input type="hidden" name="secret" value="<?php echo $secret; ?>">
					<input  type="hidden" name="qrcode" value="<?php echo $qr; ?>" >
					<input  type="hidden" name="result" value="<?php echo $result; ?>" >
					</br></br>
					<input type="submit" class="btn btn-success" name="submit" value="authenticate">

				</form>
			</div>
		</div>
	
	</div>
</div>


<?php include 'footer.php'; ?>