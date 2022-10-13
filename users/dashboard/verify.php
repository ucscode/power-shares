<?php

require __dir__ . '/sub-config.php';

$response = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {

	$response = call_user_func(function() use($__user, $link, $usermeta) {
		
		$image = sysfunc::validateImage($_FILES['fileToUpload']);
		if( $image['error_msg'] ) return array($image['error_msg'], false);
		
		$image_name = md5($__user['token']) . ".{$image['extension']}";
		$image_file = __users_contents . '/images/verify/' . $image_name;
		
		$saved = move_uploaded_file($image['tmp_name'], $image_file);
		
		if( $saved ) {
			
			$verify = $usermeta->set('kyc_document', $image_name, $__user['id']);
			
			if( !$verify ) $message = "An error occured during the verification process";
			else {
				$message = "Your KYC Document is under review";
				$usermeta->set('kyc_status', 'pending', $__user['id']);
			}
			
			return [$message, $verify];
			
		} else return ["Sorry! The image could not be uploaded", false];
		
	});
	
};

	
$kyc_status = $usermeta->get('kyc_status', $__user['id']);

if( !is_null($kyc_status) ) {
	if( $kyc_status == 'pending' ) $response = ["Your KYC Document is under review", 'warning'];
	else if( $kyc_status == 'declined' )
		$response = ["Your KYC Document was declined <br> Please upload a valid document", 'danger'];
	else {
		$response = ["Your KYC Document was approved", 'success'];
	};
};


include "header.php";

?>
 
<?php section::title( "Account Verification", !1 ); ?>

	<div class="row">
        <div class="col-md-12 col-sm-12 col-sx-12">
		
            <div class="card">
                <h4 class="card-header">
                    KYC VERIFICATION 
				</h4>
				<div class='card-body'>
				
                    <div class='bg-light p-3'>
						<ul class='mb-2'>
							<li>Complete identity verification to access all our services.</li>
							<li>All information provided by you can not be accessed by anyone.</li>
							<li>We use end to end encryption to secure all our investors' details.</li>
							<li>Enable additional security verification to secure your account.</li>
						</ul>
                    </div>
					
                    </br>
					
                    <?php sysfunc::html_notice( $response[0] ?? null, $response[1] ?? null ); ?>
					
					<?php if( $kyc_status != 'approved' ): ?>
						
						<form action="verify.php" method="POST" enctype="multipart/form-data"  class="form-horizontal form-label-left" >
							<div class="item form-group">
								<label class="control-label" for="name">
									Upload a valid means of identifcation <span class="required">*</span>
								</label>
								<div class='row'>
									<div class="col-md-8">
										<input type="file" name="fileToUpload" id="fileToUpload" class="form-control" required >
									</div>
								</div>
							</div>
							<div class="col-md-6 col-md-offset-3">
								<button type="submit"  class="btn btn-primary" value="Upload Image">Upload ID</button>
							</div>
						</form>
						
					<?php else: ?>
					
						<div class='text-center'>
							<img src='images/basic/confirm2.jpg' width='160px' class='img-fluid mb-2'>
							<h4 class='poppins'>KYC CONFIRMED</h4>
						</div>	
					
					<?php endif; ?>
					
                </div>
            </div>
			
        </div>
    </div>

<?php include 'footer.php'; ?>