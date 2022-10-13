<?php

if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
	
	$_POST = sysfunc::sanitize_input($_POST);
	
	if( empty($_POST['password']) ) unset($_POST['password']);
	
	$SQL = sQuery::update("users", $_POST, "id = {$_POST['id']}");
	$update = mysqli_query($link, $SQL);
	
	if( $update ) {
		$temp->status = !!($temp->msg = "Account details updated successfully!");
		if( isset($_POST['password']) ) {
			$temp->msg .= "<br> Password changed to <strong class='text-danger'>{$_POST['password']}</strong>";
		};
	} else $temp->status = !($temp->msg = "Account details could not be updated!");
	
}


$user = sysfunc::_data( 'users', ($_GET['id'] ?? 0));

