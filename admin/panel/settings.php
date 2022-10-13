<?php

require __dir__ . '/sub-config.php';


if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$_POST = sysfunc::sanitize_input($_POST, true);
	
	if( !empty($_FILES['logo']['size']) ) {
		$filename = basename($_FILES['logo']['name']) . "." . (PATHINFO($_FILE['logo']['name'], PATHINFO_EXTENSION));
		$target = __admin_contents . '/logo/' . $filename;
		move_uploaded_file($_FILES['logo']['tmp_name'], $target);
		$_POST['logo'] = $filename;
	};
	
	$progress = array();
	
	foreach( $_POST as $key => $value )
		$progress[] = $config->set( $key, $value );
		
	$temp->status = !in_array(false, $progress);
	
	$msg = $temp->status ? "Settings saved successfully" : "Settings was not saved";

}

include "header.php";

?>

	<div class="card">
		
		<h5 class="card-header">
			CONFIG - SETTINGS
		</h5>

         <div class="card-body">
			<div class='row'>
				<div class='col-xl-7'>
				
					<form class="form-horizontal" action="settings.php" method="POST" enctype="multipart/form-data">
						
						<?php sysfunc::html_notice( $msg, $temp->status ?? null ); ?>
						
						<!------------------- [ BUSINESS LOGO ] ----------------->
						
						<div class='mb-5'>
						
							<h5 class='poppins text-uppercase'>Site Info</h5> <hr>
							
							<div class="form-group">
								<label class='form-label'>Site Name:</label>
								<input type="text" name="site_name" placeholder="Name" value="<?php echo $config->get('site_name'); ?>"  class="form-control" required>
							</div>

							<div class="form-group">
								<label class='form-label'>Site Email:</label>
								<input type="text" name="email" placeholder="Email" value="<?php echo $config->get('email'); ?>"  class="form-control" required>
							</div>

							<div class="form-group">
								<label class='form-label'>Site Headline:</label>
								<input type="text" name="site_headline" placeholder="Headline" value="<?php echo $config->get('site_headline'); ?>"  class="form-control" required>
							</div>

						</div>
						
						
						<!------------------- [ BUSINESS INFO ] ----------------->
						
						<div class='mb-5'>
						
							<h5 class='poppins text-uppercase'>Business Info</h5> <hr>
							
							<div class="form-group">
								<label class='form-label'>Contact Phone:</label>
								<input type="text" name="contact_tel" placeholder="..." value="<?php echo $config->get('contact_tel'); ?>"  class="form-control">
							</div>
							
							<div class="form-group">
								<label class='form-label'>Contact Email:</label>
								<input type="email" name="contact_email" placeholder="..." value="<?php echo $config->get('contact_email'); ?>"  class="form-control">
							</div>
							
							<div class="form-group">
								<label class='form-label'>Contact Address:</label>
								<textarea name="contact_address" placeholder="..." class='form-control'><?php echo $config->get('contact_address'); ?></textarea>
							</div>

						</div>
						
						
						<!------------------- [ FINANCE ] ----------------->
						
						<div class='mb-5'>
						
							<h5 class='poppins text-uppercase'>Finance</h5> <hr>
							
							<div class="form-group">
								<label class='form-label'>Registration Bonus:</label>
								<input type="number" step='0.01' min='0' name="registration_bonus" placeholder="Registration bonus" value="<?php echo $config->get('registration_bonus'); ?>"  class="form-control" required>
							</div>

							<div class="form-group">
								<label class='form-label'>Deposit MIN:</label>
								<input type="number" step='0.01' min='0' name="min_deposit" placeholder="Min Deposit" value="<?php echo $config->get('min_deposit'); ?>"  class="form-control" required>
							</div>

							<div class="form-group">
								<label class='form-label'>Withdrawal MIN:</label>
								<input type="number" step='0.01' min='0' name="min_withdrawal" placeholder="Min Withdrawal" value="<?php echo $config->get('min_withdrawal'); ?>"  class="form-control" required>
							</div>

							<div class="form-group">
								<label class='form-label'>Withdrawal MAX:</label>
								<input type="number" step='0.01' min='0' name="max_withdrawal" placeholder="Max Withdrawal" value="<?php echo $config->get('max_withdrawal'); ?>"  class="form-control" required>
							</div>

							<div class="form-group">
								<label class='form-label'>Referral Bonus [%]:</label>
								<input type="number" step='0.01' min='0' name="referral_bonus" placeholder="%" value="<?php echo $config->get('referral_bonus'); ?>"  class="form-control" required>
							</div>
						
						</div>
						
						
						<!------------------- [ BUSINESS LOGO ] ----------------->
						
						<div class='mb-5'>
						
							<h5 class='poppins text-uppercase'>Logo</h5> <hr>
							
							<div class="form-group">
								<label class='form-label'>Logo:</label>
								<div class='my-1 user-select-none'>
									<img src='<?php echo $temp->logo; ?>' width='80px' class='img-fluid img-thumbnail'>
								</div>
								<input type="file" name="logo" placeholder="logo" class="form-control">
							</div>

						</div>
						
						<button type="submit" class="btn btn-success"> 
							<i class="fa fa-send"></i>&nbsp; Save Settings 
						</button>

					</form>
					
				</div>
			</div>
        </div>

	</div>

<?php include 'footer.php'; ?>