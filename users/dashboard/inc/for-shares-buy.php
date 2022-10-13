<?php 

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	
	$_POST = sysfunc::sanitize_input($_POST, true);
	$share = sysfunc::_data('shares', $_POST['id']);
	
	if( !$share ) 
		$temp->status = !($temp->msg = "An error was encountered during the process");
	
	else if( empty($share['status']) ) 
		$temp->status = !($temp->msg = "The shared plan is not available at the moment");
	
	else {
		
		foreach( $share as $key => $value ) {
			if( is_numeric($value) ) $share[$key] = (float)$value;
		};
		
		$amount = (float)$_POST['amount'];
		$share_name = "<strong class='text-muted'>{$share['name']}</strong>";
		
		if( $amount < $share['min_investment'] ) 
			$temp->status = !($temp->msg = "The Minimum investment amount for {$share_name} is \${$share['min_investment']}");
		
		else if( !empty($share['max_investment']) && $amount > $share['max_investment'] )
			$temp->status = !($temp->msg = "The Maximum investment amount for {$share_name} is \${$share['max_investment']}");
		
		else if( (float)$__user['walletbalance'] < $amount )
			$temp->status = !($temp->msg = "You do not have sufficient fund to buy the shares - {$share_name}");
		
		else {
			
			$data = array(
				"userid" => $__user['id'],
				"sid" => uniqid("shr"),
				"share_name" => $share['name'],
				"increase" => $share['increase'],
				"amount" => $amount,
				"duration" => $share['duration'],
				"last_increase_date" => date("Y-m-d H:i:s"),
				"increased_usd" => empty($share['bonus']) ? 0 : $share['bonus']
			);
			
			$DEBIT_SQL = sQuery::update( 'users', array(
				'walletbalance' => round((float)$__user['walletbalance'] - $amount, 2)
			), "id = {$__user['id']}" );
			
			### DEBIT THE INVESTOR 
			
			if( $link->query( $DEBIT_SQL ) ) {
				
				### CREATE THE INVESTMENT
				
				$INVEST_SQL = sQuery::insert( 'investments', $data );
				
				$temp->status = $link->query( $INVEST_SQL );
				
				if( $temp->status ) {
					
					$temp->msg = "{$share_name} - The share was successfully purchased";
					
					// PAY REFERRAL BONUS;
					
					$upline = user::get($__user, 'upline');
					$bonus_percent = (int)$config->get('referral_bonus');
					
					if( $upline && !empty($bonus_percent) ) {
						
						$bonus = $amount * $bonus_percent * 0.01;
						
						$REF_BONUS_SQL = sQuery::update( 'users', array(
							'walletbalance' => round((float)$upline['walletbalance'] + $bonus, 3),
							'refbonus' => round((float)$upline['refbonus'] + $bonus, 3)
						), "id = {$upline['id']}" );
						
						$link->query( $REF_BONUS_SQL );
					
					};
					
					// END REFERRAL BONUS;
					
				} else {
					
					$temp->msg = "Sorry! The process could not be completed";
					
					// RESTORE THE INVESTOR'S BALANCE
					
					$link->query( sQuery::update( 'users', array( 'walletbalance' => $__user['walletbalance'] ), "id = {$__user['id']}" ) );
				}
				
			} else $temp->status = !($temp->msg = "The share transaction could not be initialized");
			
			
		}
		
	};
	
};