<?php

### TOTAL WITHDRAWALS

$total_withdrawals = sysfunc::sum('transactions', 'usd', "request = 'withdrawal'");


### TOTAL USERS

$SQL = sQuery::select( 'users' );
$total_users = $link->query( $SQL )->num_rows;


### ONLINE USERS;

$_5min = (new dateTime("5 minutes ago"))->format("Y-m-d H:i:s");
$SQL = sQuery::select( 'users', "last_seen > '{$_5min}'" );
$online_users = $link->query( $SQL )->num_rows;


### TOTAL DEPOSITS
 
$total_deposits = sysfunc::sum('transactions', 'usd', "request = 'deposit'"); 


### TOTAL INVESTEMENTS

$total_investments = sysfunc::sum('investments', 'amount');


### TOTAL ROI

$total_roi = sysfunc::sum('investments', 'increased_usd');


### TOTAL SHARES

$SQL = sQuery::select( 'investments' );
$total_shares = $link->query( $SQL )->num_rows;


### TOTAL TICKETS

$SQL = sQuery::select( 'tickets' );
$total_tickets = $link->query( $SQL )->num_rows;
	
?>


