<?php 

require __dir__ . '/sub-config.php';

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$SQL = sQuery::update( 'investments', $_POST, "id = {$_POST['id']}" );
	$temp->status  = $link->query( $SQL );
	$temp->msg = ($temp->status) ? "The investment detail has been updated" : "The investment detail failed to update";
};

require 'header.php';

$inv = sysfunc::_data( 'investments', $_GET['id'] ?? 0 );

?>

<?php section::title("Edit Investment"); ?>

<div class='card'>
	<h4 class='card-header'>Advance Investment Edition</h4>
	<div class='card-body'>
		<?php if( empty($inv) ): ?>
			
			<div class='text-center'>
			
				<img src='<?php echo sysfunc::url( __users_contents . "/images/basic/error-monitor.jpg" ); ?>' class='img-fluid mb-2' width='370px'>
			
				<div class='alert alert-info'>
					The investment data could not be found
				</div>
				
			</div>
			
		<?php 
			else:
				
				$owner = sysfunc::_data( 'users', $inv['userid'] );
				if( !$owner ) $owner = [];
		?>
		
			<?php sysfunc::html_notice( $temp->msg, $temp->status ?? null ); ?>
			
			<div class='row'>
				<div class='col-md-8'>
					
					<form method='post'>
					
						<div class='form-group'>
							<label>Shares Name</label>
							<input type='text' class='form-control' readonly value='<?php echo $inv['share_name']; ?>'>
						</div>
					
						<div class='form-group'>
							<label>Shares Investor</label>
							<input type='text' class='form-control' readonly value='<?php echo $owner['username'] ?? null; ?>'>
						</div>
						
						<div class='form-group'>
							<label>Daily Increase</label>
							<div class='input-group'>
								<span class='input-group-text'>
									<i class='mdi mdi-percent'></i>
								</span>
								<input type='number' step='0.01' class='form-control' name='increase' value='<?php echo $inv['increase']; ?>'>
							</div>
						</div>
						
						<div class='form-group'>
							<label>Duration (Days)</label>
							<div class='input-group'>
								<span class='input-group-text'>
									<i class='mdi mdi-clock'></i>
								</span>
								<input type='number' class='form-control' name='duration' value='<?php echo $inv['duration']; ?>'>
							</div>
						</div>
						
						<div class='form-group'>
							<label>Investment</label>
							<div class='input-group'>
								<span class='input-group-text'>
									<i class='mdi mdi-currency-usd'></i>
								</span>
								<input type='number' step='0.01' class='form-control' name='amount' value='<?php echo $inv['amount']; ?>'>
							</div>
						</div>
						
						<div class='form-group'>
							<label>ROI</label>
							<div class='input-group'>
								<span class='input-group-text'>
									<i class='mdi mdi-chart-line'></i>
								</span>
								<input type='number' step='0.01' class='form-control' name='increased_usd' value='<?php echo $inv['increased_usd']; ?>'>
							</div>
						</div>
						
						<div class='form-group select-100'>
							<label>Status</label>
							<select class='form-control' name='status'>
								<?php 
									foreach(['deactivate', 'activate'] as $key => $value):
										$selected = ($key == (int)$inv['status']) ? "selected" : null;
								?>
									<option value='<?php echo $key; ?>' <?php echo $selected; ?>>	
										<?php echo ucwords($value); ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
						
						<div class='form-group select-100'>
							<label>Marked as:</label>
							<select class='form-control' name='paid'>
								<?php 
									foreach(['unpaid', 'paid'] as $key => $value):
										$selected = ($key == (int)$inv['paid']) ? "selected" : null;
								?>
									<option value='<?php echo $key; ?>' <?php echo $selected; ?>>	
										<?php echo ucwords($value); ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
						
						<input type='hidden' name='id' value='<?php echo $inv['id']; ?>'>
						
						<div class=''>
							<button class='btn btn-info btn-fw w-100 btn-lg'>
								Update
							</button>
						</div>
						
					</form>
				
				</div>
			</div>
		
		<?php endif; ?>
		
	</div>
</div>

<?php require 'footer.php'; 