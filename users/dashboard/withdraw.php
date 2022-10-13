<?php

require __dir__ . '/sub-config.php';

include 'inc/for-withdraw.php';

include "header.php";

$SQL = "
	SELECT SUM(usd) AS amount 
	FROM transactions 
	WHERE request = 'withdrawal' 
		AND userid = {$__user['id']}
";

?>

<?php section::Title("Withdrawal"); ?>

<div class='d-xl-none'>
	<?php section::show_user_balance(); ?>
</div>

<div class="row text-center justify-content-evenly">

	<?php $class = 'col-sm-6 col-md-4 col-lg-5 col-xl-4 mb-3'; ?>
	
	<div class='<?php echo $class; ?>'>
		<div class='card'>
			<div class='card-body'>
				<h3 class='text-danger'><i class='mdi mdi-star-circle fs-35'></i></h3>
				<h2>$<?php 
					$result = $link->query( $SQL . " AND status = 'approved'" )->fetch_assoc();
					echo sysfunc::if_empty($result['amount'], 0); 
				?></h2>
				<p class='text-muted my-0'>Total Withdrawal</p>
			</div>
		</div>
	</div>

	<div class='<?php echo $class; ?>'>
		<div class='card'>
			<div class='card-body'>
				<h3 class='text-warning'><i class='mdi mdi-alarm-check fs-35'></i></h3>
				<h2>$<?php 
					$result = $link->query( $SQL . " AND status = 'pending'" )->fetch_assoc();
					echo sysfunc::if_empty($result['amount'], 0); 
				?></h2>
				<p class='text-muted my-0'>Pending Withdrawal</p>
			</div>
		</div>
	</div>

	<div class='<?php echo $class; ?> d-none d-xl-block'>
		<div class='card'>
			<div class='card-body'>
				<h3 class='text-info'><i class='mdi mdi-coin fs-35'></i></h3>
				<h2>$<?php echo $__user['walletbalance']; ?></h2>
				<p class='text-muted my-0'>Wallet Balance</p>
			</div>
		</div>
	</div>
	
</div>

<hr>

<div class="card">
	
	<h4 class="card-header">Withdrawal Form</h4>
	
	<div class="card-body">
		
		<?php 
			$user_wallets = $usermeta->all($__user['id'], '^wallet');
			if( empty($user_wallets) ):
		?>
			<div class='alert alert-light rounded-0 text-center fs-13'>
				Please add your <a href='<?php echo sysfunc::url( __users_contents . '/wallets.php' ); ?>'>wallet detail</a> to receive withdrawals
			</div>
		<?php 
			else:
				$user_wallets = call_user_func(function() use($user_wallets) {
					$fresh_wallet = array();
					foreach( $user_wallets as $key => $value ) {
						$network = explode(":", $key)[1];
						$fresh_wallet[ $network ] = $value;
					};
					return $fresh_wallet;
				});
			endif; 
			
			$main_wallet = $link->query( sQuery::select('wallets', "for_withdrawal = 1") );
		?>
		
		<?php sysfunc::html_notice( $temp->msg, $temp->status ?? null ); ?>
		
		<form class="form-horizontal" method="POST" >
		
			<div class="form-group">
				<div class='input-group'>
					<span class='input-group-text'>
						<i class='mdi mdi-currency-usd'></i>
					</span>
					<input type="number" step="0.01" name="usd"  placeholder="Value in USD" class="form-control" required>
				</div>
			</div>
			
			<div class="form-group select-100">
				<select name="network" id="wallet" class="form-control text-capitalize" required>
					<option value=''>Select Wallet</option>
					<?php 
						if( $main_wallet->num_rows ):
							while($wallet = $main_wallet->fetch_assoc()):
								$key = $wallet['wallet_network'];
								if( !array_key_exists($key, $user_wallets) ) continue;
								$address = $user_wallets[ $key ];
								$selected = (($_POST['network'] ?? null) == $key) ? "selected" : null;
					?>
						<option value="<?php echo $key; ?>" data-addr="<?php echo $address; ?>" <?php echo $selected; ?>> 
							<?php echo ucfirst($key); ?> - <?php  echo $address; ?>
						</option>
					<?php 
							endwhile; 
						endif;
					?>
				</select>
			</div>
			
			<div class="modal-footer">
				<button type="submit" class="btn btn-danger pull-left">
					Request Withdrawal
				</button>
			</div>
			
		</form>
		
	</div>

</div>
<!-- /.modal-content -->


<?php include 'footer.php'; ?>