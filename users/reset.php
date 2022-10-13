<?php

require __dir__ . '/sub-config.php';
require __dir__ . '/control/for-reset.php';

### start HTML
require __dir__ . '/form-header.php';

?>

	<div class="container-scroller">
		<div class="container-fluid page-body-wrapper full-page-wrapper">
			<div class="content-wrapper d-flex align-items-center auth">
				<div class="row flex-grow">
				
					<div class="col-lg-4 mx-auto">
						<div class="auth-form-light text-left p-5">
						
							<div class="brand-logo text-center">
								<img src="<?php echo $temp->logo; ?>">
							</div>
							
							<?php sysfunc::html_notice( $temp->msg, $temp->status ?? null ); ?>
							
							<form class="pt-3" method='POST'>
							
								<?php if( !$APPROVED ): ?>
								
								<div class="form-group">
									<input type="email" name='email' class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email">
									<span class="help-block small text-danger"><?php echo $email_err ?? null; ?></span>
								</div>
								
								<?php else: ?>
								
								<div class='form-group'>
									<input type='password' name='password' class='form-control form-control-lg' placeholder='Password'>
								</div>
								
								<div class='form-group'>
									<input type='password' name='confirm-password' class='form-control form-control-lg' placeholder='Confirm Password'>
								</div>
								
								<?php endif; ?>
								
								<div class="mt-3">
									<button type='submit' class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn w-100">
										RESET
									</button>
								</div>
								
								<div class="text-center mt-4 font-weight-light"> 
									Back To <a href="<?php echo sysfunc::url( __users_login_page ); ?>" class="text-primary">Login</a>
								</div>
								
							</form>
							
						</div>
					</div>
					
				</div>
			</div>
			<!-- content-wrapper ends -->
		</div>
		<!-- page-body-wrapper ends -->
	</div>


<?php require __dir__ . '/form-footer.php'; ?>