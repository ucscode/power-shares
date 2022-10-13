<?php

require __dir__ . '/sub-config.php';
require __dir__ . '/control/for-signup.php';

### start HTML 

require __dir__ . '/form-header.php';

?> 

	<div class="container-scroller">
		<div class="container-fluid page-body-wrapper full-page-wrapper">
			<div class="content-wrapper d-flex align-items-center auth pb-5">
				<div class="row flex-grow">
				
					<div class="col-lg-4 mx-auto">
						<div class="auth-form-light text-left p-5">
						
							<div class="brand-logo text-center user-select-none">
								<img src="<?php echo $temp->logo; ?>">
							</div>
							
							<?php sysfunc::html_notice( $temp->msg ); ?>
							
							<form class="pt-3" method='POST'>
								
								<div class="form-group">
									<input type="text" name='username' class="form-control form-control-lg" id="exampleInputUsername1" placeholder="Username" value='<?php echo $username; ?>'>
									<span class="help-block text-danger small"><?php echo $username_err; ?></span>
								</div>
								
								<div class="form-group">
									<input type="email" name='email' class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email" value='<?php echo $email; ?>'>
									<span class="help-block text-danger small"><?php echo $email_err; ?></span>
								</div>
								
								<div class="form-group">
									<input type="password" name='password' class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Password" value=''>
									<span class="help-block text-danger small"><?php echo $password_err; ?></span>
								</div>
								
								<div class="form-group">
									<input type="password" name='cpassword' class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Confirm Password" value=''>
									<span class="help-block text-danger small"><?php echo $cpassword_err; ?></span>
								</div>
								
								<div class="form-group">
									<input type="number" name='phone' class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Phone" value='<?php echo $phone; ?>'>
								</div>
								
								<div class="form-group select-100">
									<select class="form-control form-control-lg" id="exampleFormControlSelect2" name='country'>
										<option value="">-- Country --</option>
										<?php foreach( sysfunc::countries() as $key => $country ): ?>
										<option value="<?php echo $key; ?>"><?php echo $country; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								
								<div class="form-group">
									<input type="text" name='address' class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Address">
									<span class="help-block text-danger small"><?php echo $address_err; ?></span>
								</div>
								
								<input type='hidden' name='referrer' value='<?php echo $temp->refid; ?>'>
								
								<div class="mb-4">
									<div class="form-check">
										<label class="form-check-label text-muted">
											<input type="checkbox" name='terms' class="form-check-input"> 
											I agree to all Terms & Conditions 
										</label>
									</div>
								</div>
								
								<div class="mt-3">
									<button type='submit' class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
										SIGN UP
									</button>
								</div>
								
								<div class="text-center mt-4 font-weight-light"> 
									Already have an account? <a href="<?php echo sysfunc::url( __users_login_page ); ?>" class="text-primary">Login</a>
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
