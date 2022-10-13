<?php 

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	
	foreach( $_POST as $key => $value ) {
		if( empty($value) ) $value = 0;
		$_POST[$key] = sysfunc::sanitize_input($value, true);
	};
	
	if( !empty($_POST['max_investment']) ) {
		if( (float)$_POST['min_investment'] > (float)$_POST['max_investment'] ) {
			$temp->error = "Min Investment cannot be greater than Max Investment";
		}
	} else if( (float)$_POST['min_investment'] < 1 ) {
		$temp->error = "Min Investment should be at least \$1";
	}
	
	if( empty($temp->error) ) {
		
		if( empty($_POST['id']) ) {
			
			unset($_POST['id']);
			$_POST['sid'] = uniqid('shr');
			$SQL = sQuery::insert( 'shares', $_POST );
			$message = ['New shares successfully added', 'The shares could not be added'];
			
		} else {
			
			$SQL = sQuery::update( 'shares', $_POST, "id = {$_POST['id']}" );
			$message = ['The shares was successfully updated', 'The shares could not be updated'];
			
		}
		
		$temp->status = $link->query( $SQL );
		
		$temp->msg = ($temp->status) ? $message[0] : $message[1];
		
	} else $temp->msg = $temp->error;
	
}
