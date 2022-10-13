<?php

define('ignore_login_check', true);

require __dir__ . '/sub-config.php';

require_once __include_path . '/PHPGangsta/GoogleAuthenticator.php';

$msg = "";
$email = sysfunc::sanitize_input($_GET['email']);

$sql= "SELECT * FROM tfa  WHERE email = '$email'";
$results = mysqli_query($link,$sql);

if(mysqli_num_rows($results)) {
	
    while($row = mysqli_fetch_assoc($results)) { 
	
		$secret = $row['secret'];

		if(isset($_POST['submit'])) {

			$email = $_POST['email'];
			$vercode = $_POST['vercode'];
			$ga = new PHPGangsta_GoogleAuthenticator();
		   
			$result = $ga->verifyCode($secret, $vercode, 3);
			
			if($result == 1) {

				$sql = "SELECT * FROM users WHERE email='$email' ";

				if($result = $link->query($sql)){
				
					$row = mysqli_fetch_array($result);
					$_SESSION['users:email'] = $row['email'];
					$_SESSION['password'] = sysfunc::encpass($row['email']);

					header("location:" . sysfunc::url( __users_contents ));
					exit;
					
				};
				
			} else $msg = "Aunthenticator does not match";

		}
	
	}; // endwhile

}


?>

<!doctype html>
<html>
<head>
	<?php require __core_views . '/head-tags.php'; ?>
</head>
<body>

	<!-- div class="container" style="margin-top:30px;background-color:#f5f8fc;padding:10%;" -->
	  
	<div class='container mt-5 bg-light p-5'>
		<div class='py-5'>
		
			<h4 class='text-center'>
				Google Authenticator Login Page
			</h4>

			<div class='my-4'>
				<?php sysfunc::html_notice( $msg ?? null ); ?>
			</div>
			
			<form action="login.php?email=<?php echo $email; ?>" method="POST">

				<input type="text" style="width:100%;padding:16px;border-radius:5px;" name="vercode" placeholder="Enter google authenticator code here">
				<input type="hidden" name="email"value="<?php echo $email; ?>">
				</br>
				</br>
				<input type="submit" class="btn btn-success" name="submit" value="Continue to Login">

			</form>
			
		</div>
	</div>

	<?php require __core_views . '/head-tags.php'; ?>
	
</body>
</html>