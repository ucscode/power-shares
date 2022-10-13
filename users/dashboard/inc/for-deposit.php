<?php

### sanitize input;

foreach( $_POST as $key => $value ) 
	$_POST[$key] = sysfunc::sanitize_input($value, true);


### Manage Payment Steps;

switch( $_POST['section'] ):
	
	// PAYMENT STAGE
	
	case "payment":
	
			if( empty($_POST['amount']) ) $temp->status = !($temp->error = "Please enter a deposit amount");
			else {
				$min_deposit = (float)$config->get('min_deposit');
				if( (float)$_POST['amount'] < $min_deposit )
				$temp->status = !($temp->error = "Minimum deposit amount is \${$min_deposit}");
			};
			if( !empty($temp->error) ) $_POST['section'] = null;
	
		break;
		
		
	// FINAL STAGE
	
	case "final":
	
			foreach( $_POST as $key => $value ) {
				if( empty($value) )
					$temp->error = ($key == 'txid') ? "Please enter payment transaction ID" : "Unexpected Fatal Error!";
			}
			
			### If no error was generated from any process above 

			if( empty($temp->error) ) {
				
				$data = $_POST;
				unset($data['section']);
				
				$data['usd'] = $data['amount'];
				unset($data['amount']);
				
				$data['userid'] = $__user['id'];
				$data['reference_id'] = uniqid('trx');
				$data['status'] = 'pending';
				$data['request'] = 'deposit';
				
				$sql = sQuery::insert('transactions', $data);
				$temp->status = $link->query( $sql );
				
				if( $temp->status ) {
					
					$temp->error = "
						Your {$data['network']} deposit of <strong>{$data['usd']} USD</strong> has been sent. <br> 
						Reference ID - <strong>{$data['reference_id']}</strong>. <br> 
						Your account balance will be updated after confirmation
					";
					
					require __dir__ . '/for-deposit@email.php';
					
				} else $temp->error = "Failed to complete request";
				
			} else $temp->status = !($_POST['section'] = 'payment');
			
		break;
	
endswitch;



