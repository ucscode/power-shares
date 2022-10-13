<?php

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	
	$result = $link->query( sQuery::select('shares', "id = {$_POST['id']}" ) );
	$share = $result->fetch_assoc();
	
	if( !$share ) $temp->status = !($temp->msg = "The shares data is missing");
	
	else {
		
		switch($_POST['action']) {
			
			case "enable":
			case "disable":
				
					$activate = array( 'status' => (int)($_POST['action'] == 'enable') );
					$SQL = sQuery::update( 'shares', $activate, "id = {$share['id']}" );
					$temp->status = $link->query( $SQL );
					$action = $activate['status'] ? "activated" : "deactivated";
					$temp->msg = ($temp->status) ? "The shares has been successfully {$action}" : "The shares could not be {$action}";
				
				break;
				
			case "delete":
			
					$SQL = "DELETE FROM shares WHERE id = '{$_POST['id']}'";
					$temp->status = $link->query( $SQL );
					$temp->msg = ($temp->status) ? "The shares has been deleted" : "The shares could not be deleted";
			
				break;
			
		};
		
	};
	
};

