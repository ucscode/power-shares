<?php

require __dir__ . '/sub-config.php';


# Request Method;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	sysfunc::sanitize_input($_POST, true);
	
	$msg = call_user_func(function() use(&$temp, $link) {
		
		$file = sysfunc::validateImage($_FILES['fileToUpload']);
		
		if( empty($file['error']) ) {
			$_POST['wallet_image'] = md5($_POST['wallet_addr']) . '.' . $file['extension'];
		} else if( $file['error'] != 4 ) return $file['error_msg'];
		
		//$_POST['email'] = $temp->admin['email'];
		
		if( empty($_POST['id']) ) {
			$SQL = sysfunc::mysql_insert_str( 'wallets', $_POST );
			$message = "New Wallet Added";
		} else {
			$SQL = sQuery::update( 'wallets', $_POST, "id = '{$_POST['id']}'" );
			$message = "Wallet Updated Successfully";		
		};
		
		$saved = $link->query( $SQL );
		
		if( $saved ) {
			
			if( empty($file['error']) ) {
				
				$target_dir = __admin_contents . "/paymenticon/" . $_POST['wallet_image'];
				$uploaded = move_uploaded_file($file['tmp_name'], $target_dir);
				
				if( !$uploaded ) {
					$message .= "<br> There was an error uploading the wallet image";
					$temp->status = 'warning';
				} else $temp->status = 'success';
				
			};
			
		} else {
			$type = empty($_POST['id']) ? 'added' : 'updated';
			$message = "
				Wallet detail was not {$type}! <br>
				{$link->error}
			";
			$temp->status = 'danger';
		}
		
		return $message;
		
	});
	
}


# Get Wallet Info

if( isset($_GET['id']) ) {
	$SQL = sQuery::select( 'wallets', "id = '{$_GET['id']}'" );
	$result = $link->query( $SQL );
	$wallet = $result->num_rows ? $result->fetch_assoc() : array();
} else $wallet = array();


# Header Address

include "header.php";


?>

<?php section::title("Add wallet"); ?>

<div class="card">

	<div class="card-body">
		<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] . (empty($wallet) ? null : "?id={$wallet['id']}"); ?>" method="POST" enctype="multipart/form-data">
			
			<?php sysfunc::html_notice( $msg, $temp->status ?? null ); ?>
			
			<input type='hidden' name='id' value='<?php echo $wallet['id'] ?? null; ?>'>
			
			<div class="form-group">
				<label>Wallet Network</label>
				<select name="wallet_network" class="form-control" required>
					<?php 
						foreach( sysfunc::crypto_coins() as $key => $value ): 
							$selected = (!empty($wallet) && $wallet['wallet_network'] == $key) ? "selected" : null;
					?>
					<option value='<?php echo $key; ?>' <?php echo $selected; ?>><?php echo $value; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<div class="form-group">
				<label>Wallet Address</label>
				<input type="text" name="wallet_addr" placeholder="e.g 0xa873A81f63C6D4FD..."  class="form-control" value="<?php echo $wallet['wallet_addr'] ?? null; ?>" required>
			</div>
			
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
					Wallet Icon <span class="required">*</span>
				</label>
				<?php if( !empty($wallet['wallet_image']) ): ?>
					<div class='mb-2'>
						<img src='paymenticon/<?php echo $wallet['wallet_image']; ?>' class='img-fluid img-thumbnail' style='height: 80px;'>
					</div>
				<?php endif; ?>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="file" name="fileToUpload" id="fileToUpload" class="form-control col-md-7 col-xs-12">
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label">
					Payment Instruction
				</label>
				<textarea name="instruction" class="form-control col-md-7 col-xs-12" placeholder="e.g Contact admin after payment" rows="4"><?php echo $wallet['instruction'] ?? null; ?></textarea>
			</div>
			
			<?php 
				$wcheck = function($name) use($wallet) {
					if( empty($wallet) || !empty($wallet[$name]) ) echo 'checked';
				};
			?>
			
			<div class="form-group">
				<label class="control-label">
					Payment Allowance
				</label>
				<div class='form-check'>
					<input type='hidden' value='0' name='for_deposit'>
					<input type='checkbox' name='for_deposit' class='form-check-input' id='check-1' value="1" <?php echo $wcheck('for_deposit'); ?>>
					<label class='form-check-label' for='check-1'>Deposit</label>
				</div>
				<div class='form-check'>
					<input type='hidden' value='0' name='for_withdrawal'>
					<input type='checkbox' name='for_withdrawal' class='form-check-input' id='check-2' value='1' <?php echo $wcheck('for_withdrawal'); ?>>
					<label class='form-check-label' for='check-2'>Withdrawal</label>
				</div>
			</div>
			
			<hr>
			
			<button style="" type="submit" class="btn btn-primary">
				<?php echo empty($wallet['id']) ? 'Add' : 'Update'; ?> Wallet 
			</button>
		
		</form>
	</div>
</div>

<?php require 'footer.php'; ?>

