<?php
	
	### CRYPTO 2 USD;
	
	$usd_rate = (new forex())->convert( $_POST['network'], 'USD' );
	
	### CRYPTO UNIT
	if( !empty($usd_rate) ) {
		$crypto_rate = (float)$_POST['amount'] / $usd_rate;
		$crypto_rate = round($crypto_rate, 8);
		$wallet = $link->query( sQuery::select('wallets', "wallet_network = '{$_POST['network']}'") )->fetch_assoc();
	} else $crypto_rate = $wallet = null;
	
	
?>


<?php 

	if( $crypto_rate && $wallet ): 
	
		$_POST['wallet_addr'] = $wallet['wallet_addr'];
		$_POST['coin_rate'] = $crypto_rate;
		
?>


	<h4 class='card-title text-uppercase'>	
		<img src='<?php echo sysfunc::url( __admin_contents ) . "/paymenticon/{$wallet['wallet_image']}"; ?>' height='35px' class='border rounded'> 
		<?php echo $_POST['network']; ?> Payment
	</h4>
	
	<div class='alert alert-info'>
		To complete your deposit, please pay the exact amount of <?php echo $_POST['network']; ?> to the given address below: 
	</div>
	
	<div class='border p-4 mb-4 text-center text-dark'>
		<div class='row'>
		
			<div class='col-md-4 mb-4'>
				<div class='mb-1'>
					<img src='<?php echo sysfunc::QRCodeURL($wallet['wallet_addr']); ?>' class='img-fluid' width='160px'>
				</div>
				Scan <?php echo $_POST['network']; ?> Address
			</div>
			
			<div class='col-md-8'>
				<div class=''>
					<div class='text-end'>
						<sup>Amount:</sup>
					</div>
					<h3 class='my-0'>
						<span class='text-primary'>
							<?php echo $crypto_rate; ?>
						</span> <?php echo $_POST['network']; ?> 
					</h3>
				</div>
				
				<hr>
				
				<div class='form-group'>
					<div class='text-end'>
						<sup>Address:</sup>
					</div>
					<input type='text' readonly name='wallet_addr' value='<?php echo $wallet['wallet_addr']; ?>' class='form-control'>
				</div>
			</div>
			
		</div>
	</div>
	
	<div class='form-group'>
		<label class='form-label'>Paste Transaction ID</label>
		<input type='text' name='txid' placeholder='TXID' class='form-control' required pattern="\w{36,}">
	</div>
	
	<?php foreach( $_POST as $key => $value ): ?>
		<input type='hidden' name='<?php echo $key; ?>' value='<?php echo $value; ?>'>
	<?php endforeach; ?>
	<input type='hidden' name='section' value='final'>
	
	<div class='form-group'>
		<button class='btn btn-info w-100 btn-fw btn-lg'>
			CONFIRM PAYMENT
		</button>
	</div>
	
	
<?php else: 
	
	require_once __dir__ . '/deposit-error.php';
	
endif; ?>