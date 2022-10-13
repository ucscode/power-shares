<?php

require __dir__ . '/sub-config.php';
  
  
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	
	unset($_POST['submit']);
	
	$response = call_user_func(function() use($__user, $link) {
		
		if( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) return ["Please enter a valid email address", false];
		
		$image = sysfunc::validateImage($_FILES['fileToUpload']);
		
		if( $image['error'] != 4 ) { // Error 4: means no image was uploaded
			
			if( !empty($image['error_msg']) ) return array($image['error_msg'], false);
			
			$image_name = md5($__user['token']) . ".{$image['extension']}";
			$image_file = __users_contents . "/images/profile/" . $image_name;
			
			$_POST['image'] = $image_name;
			
		} else $image = null;
		
		$sql = sysfunc::mysql_update_str("users", $_POST) . " WHERE id = '{$__user['id']}'";
		
		if( $link->query( $sql ) ) {
			
			$message = "Your profile has been updated";
			
			if( $image ) {
				$save_image = move_uploaded_file($image['tmp_name'], $image_file);
				if( !$save_image ) $message .= "<div class='my-3 p-5 bg-danger'>However, an error occured while uploading the image</div>";
			};
			
			return [$message, true];
			
		} else return ["Error! Profile not updated", false];
		
	});

};

$__user = (new user())->info();

include "header.php";

?>

	<?php section::title( "My Profile", false ); ?>

	<div class="card">

		<div class="card-header">
			<h4 class='mb-0'>
				<i class="fa fa-refresh"></i> PROFILE UPDATE
			</h4>
		</div>

		<div class="card-body">

			<?php sysfunc::html_notice( $response[0] ?? null, $response[1] ?? null ); ?>
		
			<div class='row'>
				
				<div class='col-xl-4 mb-4'>
					
					<div class='border p-3'>
					
						<h6 class='poppins'>Referral Link:</h6>
						
						<div class='mb-xl-3'>
							<textarea class='form-control mb-1' id='ref-link' readonly><?php echo user::get($__user, 'reflink'); ?></textarea>
							<button class='btn btn-outline-primary w-100' data-copy='#ref-link'>Copy</button>
						</div>
						
						<div class='d-none d-xl-block'>
							<div class='text-center'>
								<img src='<?php echo user::get($__user, 'avatar'); ?>' width='140px' class='img-fluid img-thumbnail mb-2'>
								<h4 class='poppins border py-3 rounded'>
									@ <?php echo number_format($__user['walletbalance'], 2); ?> USD
								</h4>
							</div>
						</div>
					
					</div>
					
				</div>
				
				<div class='col-xl-8'>
				
					<form class="form-horizontal" method="POST"  enctype="multipart/form-data">
						
						<div class="form-group">
							<input type="text"  readonly  value="<?php  echo $__user['username']?>" placeholder="username" class="form-control">
						</div>
						
						<div class="form-group">
							<label class='form-label'>Email</label>
							<input type="email"  name="email"  value="<?php  echo $__user['email']?>" placeholder="email" class="form-control" required>
						</div>
						
						<div class="form-group">
							<label class='form-label'>Phone</label>
							<input type="text"  name="phone"  value="<?php  echo $__user['phone']?>" placeholder="phone" class="form-control" required>
						</div>
						
						<div class="form-group">
							<label class='form-label'>Address</label>
							<input type="text"  name="address"  value="<?php  echo $__user['address']?>" placeholder="address" class="form-control">
						</div>
						
						<div class="form-group select-100">
							<label class='form-label'>Country</label>
							<select name='country' class='form-control'>
								<?php
									foreach( sysfunc::countries() as $code => $country ):
										$selected = ( $__user['country'] == $code ) ? 'selected' : null;
								?>
								<option value='<?php echo $code; ?>' <?php echo $selected; ?>><?php echo $country; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
								Profile Pics <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="file" name="fileToUpload" id="fileToUpload" class="form-control col-md-7 col-xs-12" >
							</div>
						</div>
						
						<hr>
						
						<div class="">
							<div class="form-group">
								<input type="submit"  name="submit" value="Update Profile" class="btn btn-info">
							</div>
						</div>
					
					</form>

				</div>
				
			</div>
			
		</div>
		
	</div>
	<!-- /.widget-user -->


<?php include 'footer.php'; ?>