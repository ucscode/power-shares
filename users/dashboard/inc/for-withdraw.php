<?php

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

	$_POST = sysfunc::sanitize_input($_POST);
	
	$temp->status = call_user_func(function() use(&$temp) {
		
		global $__user, $link, $config, $usermeta;
		
		if( empty($_POST['network']) ) return !($msg = "Please select a wallet to receive withdrawal");
		
		$min_withdrawal = (float)$config->get('min_withdrawal');
		$max_withdrawal = (float)$config->get('max_withdrawal');
		
		if( !empty($min_withdrawal) && (float)$_POST['usd'] < $min_withdrawal ) 
			return !($temp->msg = "Minimum withdrawal is {$min_withdrawal} USD");
		
		else if( !empty($max_withdrawal) && (float)$_POST['usd'] > $max_withdrawal )
			return !($temp->msg = "Maximum withdrawal is {$max_withdrawal} USD");
		
		else if( (float)$_POST['usd'] > (float)$__user['walletbalance'] ) 
			return !($temp->msg = "Insufficient wallet balance");
		
		### ---------------------------------
		
		$data = array(
			"usd" => (float)$_POST['usd'],
			"network" => $_POST['network'],
			"userid" => $__user['id'],
			"status" => "pending",
			"reference_id" => uniqid('tnx'),
			"wallet_addr" => $usermeta->get("wallet:{$_POST['network']}", $__user['id']),
			"request" => "withdrawal"
		);
		
		
		$queries = array(
		
			"
				UPDATE users 
				SET walletbalance = ROUND((walletbalance - {$data['usd']}), 4)
				WHERE id = {$__user['id']}
			",
			
			sQuery::insert( 'transactions', $data )
			
		);
		
		foreach( $queries as $SQL ) {
			if( !$link->query($SQL) ) {
				return !($temp->msg = "
					An error occured during the withdrawal process. <br> 
					Please try again or sent a support ticket for assistance
				");
			};
		};
		
		$temp->msg = "
			Your {$data['network']} withdrawal request of {$data['usd']} USD has been sent. <br>
			Reference ID - {$data['reference_id']}. <br>
			Your fund will be sent to <strong>{$data['wallet_addr']}</strong> after approval.
		";
		
		### ------- [ MAILING ] ---------
		
		require_once __dir__ . '/for-withdraw@email.php';

		return true;
		
	});
	
	// reset user variable;
	
	$__user = (new user())->info();
  
}

