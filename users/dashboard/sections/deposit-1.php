<div class='form-group'>
	<label class='form-label'>Amount (USD)</label>
	<input type='number' step='0.01' class='form-control' name='amount' placeholder='Deposit Amount' value='<?php echo $_POST['amount'] ?? null; ?>' required>
</div>

<div class='form-group select-100'>
	<label class='form-label'>Payment Network</label>
	<select class='form-select' name='network' required>
		<?php
			call_user_func(function() use($link) {
				
				$coins = sysfunc::crypto_coins();
				
				$SQL = "
					SELECT * FROM wallets
					WHERE for_deposit = 1
					ORDER BY wallet_network
				";
				
				$query = $link->query( $SQL );
				if( !$query->num_rows ) return;
				
				while( $wallet = $query->fetch_assoc() ):
				
					$key = $wallet['wallet_network'];
					if( !isset($coins[$key]) ) continue;
					$name = $coins[$key];
					
		?>
			<option value='<?php echo $key; ?>'>
				<?php echo $name; ?>
			</option>
		<?php 
				endwhile;
			});
		?>
	</select>
</div>

<input type='hidden' name='section' value='payment'>

<div class='form-group'>
	<button class='btn btn-outline-primary btn-fw w-100'>
		Proceed
	</button>
</div>	