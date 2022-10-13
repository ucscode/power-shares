<?php

require __dir__ . '/sub-config.php';

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

	$_POST = sysfunc::sanitize_input( $_POST );
	
	$results = array();
	
	foreach( $_POST as $key => $value ) {
		if( empty($value) ) continue;
		$temp->status = $usermeta->set( "wallet:{$key}", $value, $__user['id'] );
		if( $temp->status ) {
			$results[] = $key;
			$temp->status = null;
		}
	};
	
	if( !empty($results) ) {
		$temp->msg = implode(", ", $results);
		$temp->msg .= " wallet updated successfully";
		$__user = (new user())->info();
	} else {
        $temp->msg = "No wallet detail was not updated";
    };
	
};

include "header.php";

?>


<?php section::title( "Wallet details" ); ?>

<div class="card">

	<div class="card-body">
	
		<?php sysfunc::html_notice($temp->msg, $temp->status ?? null); ?>
		
		<?php 
			$SQL = "
				SELECT * FROM wallets
				WHERE for_withdrawal = 1
			";
			$result = $link->query( $SQL );
			
			if( $result->num_rows ):
		?>
			
			<form class="form-horizontal" method="POST" >
				
				<div class='position-relative'>
				
					<div class='water-mark'>
						<img src='images/basic/payday.jpg' width='200px' class='img-fluid'>
					</div>
					
					<div class='position-relative'>
					
						<?php 
							$crypto =  sysfunc::crypto_coins();
							while( $wallet = $result->fetch_assoc() ):
								$key = $wallet['wallet_network'];
						?>
						
						<div class="form-group">
							<label><?php echo $crypto[$key]; ?></label>
							<input type="text"  name="<?php echo $key; ?>" placeholder="<?php echo $wallet['wallet_network']; ?> Wallet" class="form-control" value="<?php echo $usermeta->get("wallet:{$key}", $__user['id']); ?>">
						</div>
						
						<?php endwhile; ?>
					
					</div>
					
				</div>
				
				<hr/>
				
				<button style="" type="submit" class="btn btn-primary btn-fw">
					<i class='fas fa-save me-1'></i> Save Wallet 
				</button>
				
			</form>
			
		<?php else: ?>
		
			<div class='text-center'>
				<img src='images/basic/error2.jpg' class='img-fluid mb-2' width='160px'>
				<h2>Wallet Detail Configuration is not available</h2>
			</div>
		
		<?php endif; ?>
		
	</div>
</div>

<?php include 'footer.php'; ?>