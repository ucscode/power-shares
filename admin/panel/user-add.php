<?php 

require __dir__ . '/sub-config.php';

require __dir__ . '/inc/for-user-add.php';

require 'header.php';

?>

	<?php section::title( "New User", false ); ?>
	
	<div class='card'>
		<div class='card-body'>
			
			<?php sysfunc::html_notice( $temp->msg, $temp->status ?? null ); ?>
			
			<div class='row'>
				<div class='col-lg-8'>
				
					<form method='post'>
						
						<div class='form-group'>
							<label class='form-label'>Username</label>
							<input type='text' name='username' class='form-control' value='<?php echo $_POST['username'] ?? null; ?>' required>
						</div>
						
						<div class='form-group'>
							<label class='form-label'>Email</label>
							<input type='email' name='email' class='form-control' value='<?php echo $_POST['email'] ?? null; ?>' required>
						</div>
						
						<div class='form-group'>
							<label class='form-label'>Password</label>
							<input type='text' name='password' class='form-control' value='<?php echo $_POST['password'] ?? null; ?>' required>
						</div>
						
						<div class='form-group select-100'>
							<label class='form-label'>Country</label>
							<select name='country' class='form-control'>
								<?php 
									foreach( sysfunc::countries() as $key => $value ):
										$selected = ($key == ($_POST['country'] ?? null)) ? "selected" : null;
								?>
									<option value='<?php echo $key; ?>' <?php echo $selected; ?>>
										<?php echo $value; ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
						
						<div class='form-group'>
							<div class='form-check'>
								<input type='hidden' name='confirm' value='0'>
								<input type='checkbox' class='form-check-input' name='confirm' value='1' id='c-email' <?php echo !empty($_POST['confirm'] ?? 1) ? 'checked' : null; ?>>
								<label class='form-check-label' for='c-email'>Confirm Email</label>
							</div>
							<div class='form-check'>
								<input type='hidden' name='alert' value='0'>
								<input type='checkbox' class='form-check-input' name='alert' value='1' id='alert' <?php echo !empty($alert ?? 1) ? 'checked' : null; ?>>
								<label class='form-check-label' for='alert'>Notify User</label>
							</div>
						</div>
						
						<div class='form-group'>
							<button class='btn btn-primary'>
								Add User
							</button>
						</div>
						
					</form>
			
				</div>
			</div>
			
		</div>
	</div>

<?php require 'footer.php'; ?>