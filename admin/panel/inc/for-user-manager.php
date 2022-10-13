<?php

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	
	switch( $_POST['action'] ) {
		
		case 'delete':
		
				$SQL = "DELETE FROM users WHERE id = {$_POST['id']}";
				$temp->status = $link->query( $SQL );
				$msg = ($temp->status) ? "User deleted successfully" : "User not deleted";
		
			break;
		
	};
	
};