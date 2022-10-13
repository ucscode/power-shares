<?php 

require __dir__ . '/sub-config.php';

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	
	$_POST = sysfunc::sanitize_input($_POST, true);
	
	$_POST['userid'] = $__user['id'];
	
	$SQL = sQuery::select( 'ticket_replies', "msgid = '{$_POST['msgid']}' AND reply = '{$_POST['reply']}'" );
	if( $link->query( $SQL )->num_rows )
		$temp->msg = "Error: Duplicate Reply Message";
	else {
		$SQL = sQuery::insert( 'ticket_replies', $_POST );
		if( !$link->query( $SQL ) ) $temp->msg = "The reply could not be sent";
	}
	
};

require 'header.php';

$ticket = sysfunc::_data( 'tickets', ($_GET['id'] ?? null), 'msgid' );

?>

	<?php section::title( "Support Ticket", false ); ?>
	
	<div class='row'>
		<div class='col-xl-8 col-lg-12 col-md-10 col-sm-12 m-auto'>
			<div class='card'>
				<div class='card-body'>
					
					<?php if( !$ticket ): ?>
						
						<div class='text-center'>
							<img src='images/basic/error1.jpg' width='120px' class='img-fluid'>
							<h2 class='my-2'>No support ticket found</h2>
							<a href='ticket-list.php' class='btn btn-outline-primary d-inline-block mt-2 btn-fw'>
								Go to Tickets
							</a>
						</div>
					
					<?php 
						else: 
							
							$color = sysfunc::color( $ticket['status'] );
							$replies = $link->query( sQuery::select( 'ticket_replies', "msgid = '{$ticket['msgid']}'" ) );
							
							if( $replies->num_rows ) {
								$SQL = sQuery::update( 'ticket_replies', ['status' => 1], "msgid = '{$ticket['msgid']}' AND userid = 0" );
								$link->query( $SQL );
							};
							
					?>
					
						<h4 class='poppins'>#ID: <?php echo $ticket['msgid']; ?></h4>
						
						<hr>
						
						<div class='fs-13'>
							
							<div class='mb-2 user-select-none'>
								<i class='mdi mdi-star-circle text-warning'></i> STATUS: 
								<label class='badge badge-<?php echo $color; ?> ms-1'><?php echo $ticket['status']; ?></label>
							</div>
							
							<div class='bg-light p-3 mb-2'>
								<?php echo nl2br($ticket['message']); ?>
							</div>
							
							<div class='border mb-2'></div>
							
							<?php sysfunc::html_notice( $temp->msg, false ); ?>
							
							<div class='ticket-container'>
							
								<?php if( !$replies->num_rows ): ?>
									
									<div class='text-center poppins border p-2'>
										No Reply!
									</div>
									
								<?php else: ?>
									<div class='p-3 bg-light chat-frame' data-scroll-to='bottom'>
										<div class='row'>
											<?php 
												while( $reply = $replies->fetch_assoc() ): 
													$pos = empty($reply['userid']) ? 'left text-white' : 'text-success bg-white';
											?>
												<div class='col-md-9 mb-2 col-11 <?php if( !empty($reply['userid']) ) echo 'ms-auto'; ?>'>
													<div class='border rounded p-2 <?php echo $pos; ?>'>
														<?php echo nl2br($reply['reply']); ?>
													</div>
												</div>
											<?php endwhile; ?>
										</div>
									</div>
								<?php endif; ?>
								
							</div>
						
						</div>
						
						<hr>
						
						<?php if( !in_array($ticket['status'], ['resolved', 'closed']) ): ?>
							
							<form method='post'>
								<input type='hidden' name='msgid' value='<?php echo $ticket['msgid']; ?>'>
								<div class='mb-1'>
									<textarea class='form-control' name='reply' placeholder='Write reply' required></textarea>
								</div>
								<div class=''>
									<button class='btn btn-outline-info w-100'>
										Send <i class='fas fa-paper-plane'></i>
									</button>
								</div>
							</form>
						
						<?php endif; ?>
					
					<?php endif; ?>
					
				</div>
			</div>
		</div>
	</div>

<?php require 'footer.php'; ?>