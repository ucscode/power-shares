<?php 

require __dir__ . '/sub-config.php';

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	
	$_POST = sysfunc::sanitize_input( $_POST, TRUE );
	
	if( isset($_POST['delete']) ) {
	
		$SQL = "DELETE FROM ticket_replies WHERE id = '{$_POST['delete']}'";
		$temp->status = $link->query( $SQL );
		if( !$temp->status ) $temp->msg = "Message not deleted";
	
	} else if( isset($_POST['status']) ) {
		
		$SQL = sQuery::update( 'tickets', array( 'status' => $_POST['status'] ), "msgid = '{$_POST['msgid']}'" );
		$temp->status = $link->query( $SQL );
		$temp->msg = ($temp->status) ? "Status updated" : "Status not updated";
		
	} else {
		
		$SQL = sQuery::select( 'ticket_replies', "msgid = '{$_POST['msgid']}' AND reply = '{$_POST['reply']}' AND userid = 0" );
		$duplicate = $link->query( $SQL )->num_rows;
		
		if( $duplicate ) $temp->msg = 'Error: Duplicate Reply';
		else {
			$SQL = sQuery::insert( 'ticket_replies', $_POST );
			$temp->status = $link->query( $SQL );
			if( !$temp->status ) $temp->msg = "Reply not sent";
		};
		
	};
	
};

require 'header.php';

$ticket = sysfunc::_data( 'tickets', ($_GET['id'] ?? 0) );

?>

	<?php section::title( "Ticket Support", false ); ?>
	
	<?php sysfunc::html_notice( $temp->msg, $temp->status ?? null ); ?>
	
	<div class='row'>
		<div class='col-xl-5 mb-4'>
			<div class='card'>
				<div class='card-body fs-14'>
					
					<div class='poppins fw-700 d-flex justify-content-between'>
						<div>TICKED ID:</div>
						<div class='text-end'>
							<span class='text-info'><?php echo $ticket['msgid']; ?></span>
						</div>
					</div>
					
					<hr>
					
					<form method='post'>
						<div class='form-group'>
							<div class='mb-1'>
								<i class='mdi mdi-star-circle text-warning'></i> <?php echo ucwords($ticket['status']); ?>
							</div>
							<div class='select-100 mb-1'>
								<select class='form-control' name='status'>
									<?php 
										$status = array('pending', 'open', 'resolved', 'closed');
										foreach( $status as $value ):
											$select = ($value == $ticket['status']) ? 'selected' : null;
									?>
									<option value='<?php echo $value; ?>' <?php echo $select; ?>>
										<?php echo ucwords($value); ?>
									</option>
									<?php endforeach; ?>
								</select>
							</div>
							<input type='hidden' name='msgid' value='<?php echo $ticket['msgid']; ?>'>
							<div class=''>
								<button class='btn btn-outline-info w-100'>
									Save
								</button>
							</div>
						</div>
					</form>
					
					<div class=''>
						<div class='mb-2 d-flex justify-content-between text-muted'>
							<div class='fw-700'>TITLE:</div>
							<div><?php echo $ticket['date']; ?></div>
						</div>
						<div class='p-3 bg-light mb-2'>
							<?php echo $ticket['title']; ?>
						</div>
						<hr>
						<h6 class='poppins text-muted'>MESSAGE:</h6>
						<div class='p-3 border bg-secondary text-white rounded'>
							<?php echo nl2br( $ticket['message'] ); ?>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
		<div class='col-xl-7'>
			<div class='card'>
				<div class='card-body fs-14'>
					
					<?php
						$user = sysfunc::_data( 'users', $ticket['userid'] );
						$replies = $link->query( sQuery::select( 'ticket_replies', "msgid = '{$ticket['msgid']}'" ) );
						
						if( $replies->num_rows ) {
							$SQL = sQuery::update( 'ticket_replies', array( 'status' => '1' ), "msgid = '{$ticket['msgid']}' AND userid <> 0" );
							$link->query( $SQL );
						};
					?>
					
					<div class='poppins'>
						<i class='fas fa-user-circle'></i>
						<?php if( !empty($user['username']) ): ?>
							<a href='user-edit.php?id=<?php echo $user['id']; ?>'>
								<?php echo $user['username']; ?>
							</a>
						<?php else: ?>
							<span class='text-muted'><?php echo $USER_OFF; ?></span>
						<?php endif; ?>
					</div>
					
					<hr>
					
					<div class='border p-3 fs-13 bg-light chat-frame' data-scroll-to='bottom'>
						<div class='row'>
							<?php if( !$replies->num_rows ): ?>
								<div class='text-center col-12'>
									No Reply!
								</div>
							<?php 
								else:
									while( $reply = $replies->fetch_assoc() ):
										if( empty($reply['userid']) ) $pos = "bg-success text-white border-right";
										else $pos = "bg-secondary text-white";
							?>
									<div class='col-11 col-md-10 mb-2 <?php if( empty($reply['userid']) ) echo "ms-auto"; ?>'>
										<div class='border rounded p-2 <?php echo $pos; ?>'>
											<div class='reply'>	
												<?php echo nl2br($reply['reply']); ?>
											</div>
											<div class='border-top d-flex fs-12 text-muted justify-content-between pt-1'>
												<div><span role='button' class='trasher' data-trash='<?php echo $reply['id']; ?>'><i class='fas fa-trash'></i></span></div>
												<div><?php echo $reply['date']; ?></div>
											</div>
										</div>
									</div>
									
							<?php 	endwhile;
								endif; 
							?>
						</div>
					</div>
					
					<div class='mt-3'>
						<form method='post'>
							<input type='hidden' name='msgid' value='<?php echo $ticket['msgid']; ?>'>
							<input type='hidden' name='userid' value='0'>
							<textarea class='form-control mb-2' name='reply' placeholder='Reply here' required></textarea>
							<button class='btn btn-info w-100'>
								Respond
							</button>
						</form>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	
	<?php events::addListener('@footer', function() { ?>
	
		<form id='trasher' method='post'>
			<input type='hidden' name='delete'>
		</form>
		<script>
			$("[data-trash]").click(function() {
				var key = this.dataset.trash;
				swal({
					text: "Are you sure you want to delete the message?",
					icon: 'warning',
					buttons: ['No', 'Yes']
				}).then(function(ok) {
					if( !ok ) return;
					$("#trasher input").val(key).parent().get(0).submit();
				});
			});
		</script>
	
	<?php }); ?>
	
<?php require 'footer.php'; ?>