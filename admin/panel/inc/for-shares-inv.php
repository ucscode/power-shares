<?php

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	
	$inv = sysfunc::_data( 'investments', $_POST['id'] );
	
	switch( $_POST['action'] ) {
		
		case 'activate':
		case 'deactivate':
		
				$SQL = sQuery::update( 'investments', array('status' => (int)($_POST['action'] == 'activate')), "id = {$inv['id']}" );
				$temp->status = $link->query( $SQL );
				$temp->msg = ($temp->status) ? "Shared plan successfully " : "The shared plan could not be ";
				$temp->msg .= "{$_POST['action']}d";
			
			break;
			
			
		case "pay":
		
				$pay = array( 
					'status' => 0,
					'paid' => 1
				);
				
				$SQL = sQuery::update( 'investments', $pay, "id = {$inv['id']}" );
				$temp->status = $link->query( $SQL );
				$temp->msg = ($temp->status) ? "Shares marked as paid" : 'The shares could not be updated';
				
				$temp->msg .= "<br>";
				
				if( empty($inv['paid']) ) {
					if( $temp->status ) {
						$SQL = " 
							UPDATE users
							SET walletbalance = ROUND((walletbalance + {$inv['increased_usd']}), 4)
							WHERE id = {$inv['userid']}
						";
						$status = $link->query( $SQL );
						if($status) $temp->msg .= "The investor balance has been updated";
						else {
							$temp->msg .= "The investor balance could not be updated! Try updating manually";
							$temp->status = 'warning';
						};
					} else $temp->msg .= "No attempt was made to update investor balance";
				} else {
					$temp->msg .= "The investor had already been funded";
					$temp->status = 'warning';
				}
			
			break;
			
		
		case "delete":
				
				$SQL = "DELETE FROM investments WHERE id = {$_POST['id']}";
				$temp->status = $link->query( $SQL );
				$temp->msg = ($temp->status) ? "Investment successfully deleted" : "Investment failed to delete";
				
			break;
		
	};
	
};

