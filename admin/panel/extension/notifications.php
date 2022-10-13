<?php

events::addListener('@footer', function() use($link) {
	
	$alert = array();
	
	// DEPOSIT
	$SQL = sQuery::select( "transactions", "request = 'deposit' AND status = 'pending'" );
	$alert[] = array( 
		"text" => "deposit request", 
		"count" => $link->query( $SQL )->num_rows 
	);


	// WITHDRAWAL
	$SQL = sQuery::select( "transactions", "request = 'withdrawal' AND status = 'pending'" );
	$alert[] = array(
		"text" => "pending withdrawal request",
		"count" => $link->query( $SQL )->num_rows,
		"type" => 'warning'
	);


	// KYC
	$SQL = sQuery::select( 'usermeta', "_key = 'kyc_status' AND _value = 'pending'" );
	$alert[] = array(
		"text" => "awaiting KYC validation",
		"count" => $link->query( $SQL )->num_rows
	);


	// TICKET
	$SQL = sQuery::select( 'tickets', "status = 'pending'" );
	$alert[] = array(
		"text" => "new support ticket",
		"count" => $link->query( $SQL )->num_rows
	);


	// TICKET REPLIES
	$SQL = sQuery::select( 'ticket_replies', "userid <> 0 AND status = 0" );
	$alert[] = array(
		"text" => "awaiting ticket replies",
		"count" => $link->query( $SQL )->num_rows
	);


	$Timeout = 2000;
	
	foreach( $alert as $data ):
		if( empty($data['count']) ) continue;
			if( empty($data['type']) ) $data['type'] = 'info';
?>
		<script>
			setTimeout(function() {
				toastr[<?php echo "'{$data['type']}'"; ?>](<?php echo "'{$data['count']} {$data['text']}'"; ?>); 
			}, <?php echo $Timeout; ?>);
		</script>
<?php 
		$Timeout += 3000;
	endforeach;
	
	$_SESSION['admin:alert'] = true;
	
});
