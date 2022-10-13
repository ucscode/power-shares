<?php

require_once __dir__ . '/sub-config.php';

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$_POST = sysfunc::sanitize_input($_POST);
	$_POST['paid'] = empty($_POST['txid']) ? 0 : 1;
	$SQL = sQuery::update( "transactions", $_POST, "id = {$_POST['id']}" );
	$temp->status = $link->query( $SQL );
	$temp->msg = ($temp->status) ? "Withdrawal detail updated" : "Withdrawal detail not updated";
};

require 'header.php';

$tx = sysfunc::_data( 'transactions', $_GET['id'] ?? 0 );

?>

<div class='card'>

	<h4 class='card-header text-uppercase'>
		Manage Withdrawal
	</h4>
	
	<div class='card-body'>
	
		<?php 
		
			if( $tx ):
			
				$crypto = sysfunc::crypto_coins();
				$network = $tx['network'];
				
				if( empty($tx['coin_rate']) ) {
					$usd = (new forex())->convert( $network, 'USD' );
					$rate = (empty($usd)) ? '0.0000' : round((float)$tx['usd'] / $usd, 8);
					$rate_color = 'primary';
				} else {
					$rate = $tx['coin_rate'];
					$rate_color = 'warning';
				}
				
				$wallet = sysfunc::_data('wallets', $network, 'wallet_network');
				
		?>
			
			<div class='row'>
			
				<div class='col-md-5 col-lg-4 text-center mb-4'>
					<div class='border py-4 px-3'>
					
						<?php if( $wallet ): ?>
							<div class='mb-3'>
								<img src='<?php echo "paymenticon/{$wallet['wallet_image']}"; ?>' width="50px" class='img-fluid img-thumbnail'>
							</div>
						<?php endif; ?>
						
						<h5 class='poppins'>
							<?php echo $crypto[ $network ]; ?> 
						</h5>
						
						<div class='qrcode'>
							<img src='<?php echo sysfunc::QRCodeURL($tx['wallet_addr']); ?>' width="160px" class='img-fluid'>
						</div>
						
						<h3 class='poppins'>
							<span class='text-<?php echo $rate_color; ?>'><?php echo $rate; ?></span>
							<span class='text-muted'><?php echo $network; ?></span>
						</h3>
						
						<p class='bg-light p-2 fs-20 font-1'>
							$ <?php echo number_format($tx['usd'],2); ?>
						</p>
						
						<p class='poppins mb-2 text-muted'>Address</p>
						
						<input class='form-control' readonly value='<?php echo $tx['wallet_addr']; ?>'>
						
						<div class='mt-2'>
							<span class='badge badge-<?php echo sysfunc::color(!empty($tx['paid']) ? 'success' : $tx['status']); ?> w-100 py-3 text-capitalize'>
								<?php echo !empty($tx['paid']) ? "Paid" : $tx['status']; ?>
							</span>
						</div>
						
						<hr>
						
						<?php echo $tx['date']; ?>
						
					</div>
				</div>
				
				<div class='col-md-7 col-lg-8'>
					<div class='py-2 px-3'>
					
						<?php sysfunc::html_notice( $temp->msg, $temp->status ?? null ); ?>
						
						<form method='post'>
						
							<div class='form-group'>
								<label>Reference ID</label>
								<input type='text' class='form-control' readonly value='<?php echo $tx['reference_id']; ?>'>
							</div>
						
							<div class='form-group'>
								<label>Amount in USD</label>
								<div class='input-group'>
									<span class='input-group-text'>
										<i class='mdi mdi-coin'></i>
									</span>
									<input type='number' step='0.01' name='usd' class='form-control' placeholder='Withdrawal USD' value='<?php echo $tx['usd']; ?>'>
								</div>
							</div>
						
							<div class='form-group'>
								<label>
									Amount paid in <?php echo $network; ?>
								</label>
								<div class='input-group'>
									<span class='input-group-text'>
										<i class='mdi mdi-format-horizontal-align-center'></i>
									</span>
									<input type='number' step='0.00000001' name='coin_rate' class='form-control' placeholder='Withdrawal <?php echo $network; ?>' value='<?php echo $tx['coin_rate']; ?>'>
								</div>
							</div>
						
							<div class='form-group'>
								<label>Wallet</label>
								<div class='input-group'>
									<span class='input-group-text'>
										<i class='mdi mdi-link'></i>
									</span>
									<input type='text' name='wallet_addr' class='form-control' placeholder='<?php echo $tx['wallet_addr']; ?> Transaction ID' value='<?php echo $tx['wallet_addr']; ?>'>
								</div>
							</div>
							
						
							<div class='form-group'>
								<label>TXID</label>
								<div class='input-group'>
									<span class='input-group-text'>
										<i class='mdi mdi-information-outline'></i>
									</span>
									<input type='text' name='txid' class='form-control' placeholder='<?php echo $network; ?> Transaction ID' value='<?php echo $tx['txid']; ?>'>
								</div>
							</div>
							
							<div class='form-group select-100'>
								<label>Status</label> 
								<?php if( !empty($tx['paid']) && $tx['status'] != 'approved' ): ?>
									<div class='fs-11 mb-1 text-danger'>
										<i class='mdi mdi-flag-triangle'></i> Recommended: Mark as approved
									</div>
								<?php endif; ?>
								<select class='form-control' name='status'>
									<?php
										foreach(['approved', 'disapproved', 'pending'] as $value):
											$selected = ($value == $tx['status']) ? "selected" : null;
									?>
										<option value='<?php echo $value; ?>' <?php echo $selected; ?>>
											<?php echo ucfirst($value); ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
							
							<input type='hidden' name='id' value='<?php echo $tx['id']; ?>'>
							
							<div class='form-group'>
								<button class='btn btn-success w-100'>
									Update Withdrawal
								</button>
							</div>
					
						</form>
						
					</div>
				</div>
				
			</div>
			
		<?php else: ?>
		
			
		
		<?php endif; ?>
		
	</div>
	
</div>

<?php require 'footer.php'; 