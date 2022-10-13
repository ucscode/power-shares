<?php 

// !get referrer id;

$temp->refid = call_user_func(function() {
	if( !empty($_GET['ref']) ) {
		$sponsor = sysfunc::_data( 'users', ($_GET['ref'] ?? 0), 'refcode' );
		$_SESSION['user:refid'] = ($sponsor) ? $sponsor['id'] : 0;
	};
	return $_SESSION['user:refid'] ?? 0;
});


// !increment shares by traffic;

$yesterday = (new datetime('1 day ago'))->format('Y-m-d H:i:s');

$SQL = sQuery::select( 'investments', "
	last_increase_date <= '{$yesterday}'
	AND paid = 0
	AND status = 1
" );

$invs = $link->query( $SQL );

while( $inv = $invs->fetch_assoc() ) {
	//
	shares::increment( $inv['userid'] );
};