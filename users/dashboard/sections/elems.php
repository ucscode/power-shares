<?php 

events::addListener('@footer', function() {
	
	global $__user, $link;
	
	$SQL = "
		SELECT COUNT(ticket_replies.msgid) AS replies
		FROM tickets
		LEFT JOIN ticket_replies
			ON tickets.msgid = ticket_replies.msgid
		WHERE tickets.userid = {$__user['id']}
			AND ticket_replies.userid <> {$__user['id']} 
			AND ticket_replies.status = 0
	";

	$replies = $link->query( $SQL )->fetch_assoc()['replies'];

	if( !empty($replies) ):
?>
	<script>
		//toastr.options.positionClass = 'toast-bottom-right';
		toastr.info(`You have <?php echo $replies; ?> new replies on your ticket`);
	</script>
<?php 
	endif;
});


## Header Ads

$ad_codes = array(
	'header_code' => '@header',
	'footer_code' => '@footer'
);

foreach( $ad_codes as $key => $position ) {
	$code = $config->get( $key );
	if( !empty($code) ) {
		events::addListener($position, function() use($code) {
			echo $code;
		});
	}
};

require __dir__ . '/announce-modal.php';