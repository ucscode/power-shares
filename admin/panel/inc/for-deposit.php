<?php 

$TXSQL = $MINI_SQL . "WHERE transactions.id = {$_POST['id']}";

$tx = $link->query( $TXSQL )->fetch_assoc();

if( !$tx ) $temp->status = !($temp->msg = "The transaction data is missing!");

else {
	
	switch($_POST['action']):

		case "approve":
		
				$SQL = []; $result = [];
				
				$approval = array( 'status' => 'approved' );
				
				if( empty($tx['paid']) ) {
					$new_balance =  array(
						'walletbalance' => round((float)$tx['walletbalance'] + (float)$tx['usd'], 2)
					);
					$SQL[1] = sQuery::update( "users", $new_balance, "id = {$tx['userid']}" );
					$approval['paid'] = 1;
				};
				
				$SQL[0] = sQuery::update( "transactions", $approval, "id = {$tx['id']}" );
				
				sort($SQL);
				
				foreach( $SQL as $Query ) {
					$result[] = $link->query( $Query );
				};
				
				$temp->status = $result[0];
				$temp->msg = ($temp->status) ? "The deposit transaction has been approved" : "The deposit transaction could not be approved";
				
				if( isset($result[1]) ) {
					$temp->msg .= "<br>";
					$temp->msg .= $result[1] ? "The user balance has been updated" : "The user balance could not be updated! Try updating manually";
				};
				
			break;
			
		
		case "decline":
		
				$approval = array('status' => 'declined');
				
				$SQL = sQuery::update( 'transactions', $approval, "id = {$tx['id']}" );
				
				$temp->status = $link->query( $SQL );
				
				$temp->msg = ($temp->status) ? "The deposit transaction has been declined" : "The deposit transaction failed to decline";
			
			break;
			
			
		case "delete":
		
				$SQL = "DELETE FROM transactions WHERE id = {$tx['id']}";
				
				$temp->status = $link->query( $SQL );
				
				$temp->msg = ($temp->status) ? "The deposit transaction was successfully deleted" : "The deposit transaction failed to delete";
			
			break;

	endswitch;

};

