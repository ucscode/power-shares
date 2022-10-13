<?php

require __dir__ . '/sub-config.php';
require __dir__ . '/control/for-signin.php';

### start HTML 

require __dir__ . '/form-header.php';

?>

	<div class="container-scroller">
		<div class="container-fluid page-body-wrapper full-page-wrapper">
			<div class="content-wrapper d-flex align-items-center auth">
				<div class="row flex-grow">
				
					<div class="col-lg-4 mx-auto">
						<div class="auth-form-light text-left p-5">
						
							<div class="brand-logo text-center user-select-none">
								<img src="<?php echo $temp->logo; ?>">
							</div>
							
							<?php sysfunc::html_notice( $temp->msg ); ?>
				
							<form class="pt-3" method='POST'>
							
								<div class="form-group">
									<input type="email" name='email' class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email">
									<span class="small help-block text-danger"><?php echo $email_err; ?></span>	
								</div>
							
								<div class="form-group">
									<input type="password" name='password' class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
									<span class="help-block small text-danger mt-1"><?php echo $password_err; ?></span>
								</div>
								
								<div class="mt-3">
									<button type='submit' class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
										SIGN IN
									</button>
								</div>
								
								<hr>
								
								<div class="my-2 d-flex justify-content-between align-items-center">
									<div class="form-check">
										<label class="form-check-label text-muted">
										<input type="checkbox" class="form-check-input"> Keep me signed in </label>
									</div>
									<a href="<?php echo sysfunc::url( __users_reset_password_page ); ?>" class="auth-link text-black">Forgot password?</a>
								</div>
								
								<div class="text-center mt-4 font-weight-light"> 
									Don't have an account? <a href="<?php echo sysfunc::url( __users_register_page ); ?>" class="text-primary">Create</a>
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
    
<?php include __dir__ . '/form-footer.php'; ?>