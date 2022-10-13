<?php

require __dir__ . '/sub-config.php';

// delete investor
if(isset($_POST['delete'])){
	
	sysfunc::sanitize_input($_POST, true);
	
	$SQL = "DELETE FROM tickets WHERE msgid='{$_POST['delete']}'";
	
	$msg = $link->query( $SQL ) ? "Message deleted successfully!" : "Message not deleted! ";
	
}


include 'header.php';

?>

	<?php section::title( 'Tickets', false ); ?>
	
<div class="card">

	<div class="card-body">
		<div class="">

			<?php sysfunc::html_notice( $msg ); ?>

			<div class="table-responsive">
				<table class="display table table-striped table-bordered"  id="example">
					<thead>
						<tr class="info">
							<th>#</th>
							<th>User</th>
							<th>Title</th>
							<th>Date</th>
							<th>Status</th>
							<th>Replies</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php 

					$SQL = "
						SELECT 
							tickets.*,
							COUNT(ticket_replies.msgid) AS replies,
							users.username
						FROM tickets 
						LEFT JOIN users 
							ON tickets.userid = users.id
						LEFT JOIN ticket_replies
							ON tickets.msgid = ticket_replies.msgid
						GROUP BY tickets.msgid
						ORDER BY id DESC
					";
					
					$nav = new nav($SQL);
					
					$result = $nav->result();

						if(mysqli_num_rows($result)):
							while($ticket = mysqli_fetch_assoc($result)): 
						 
								$color = sysfunc::color( $ticket['status'] );
							
					?>
								<tr class="primary">
									<td><?php echo $ticket['msgid'];?></td>
									<td>
										<?php if( !empty($ticket['username']) ): ?>
										<a href='user-edit.php?id=<?php echo $ticket['userid']; ?>'>
											<?php echo $ticket['username'];?>
										</a>
										<?php else: ?>
											<span class='text-muted'><?php echo $USER_OFF; ?></span>
										<?php endif; ?>
									</td>
									<td><?php echo $ticket['title'];?></td>
									<td><?php echo $ticket['date'];?></td>
									<td>	
										<label class='badge badge-<?php echo $color; ?>'>
											<?php echo $ticket['status']; ?>
										</label>
									</td>
									<td><?php echo $ticket['replies']; ?></td>
									<td>
										<form method='POST'>
											<div class='btn-group'>
												<a class="btn btn-success text-nowrap" href="ticket-support.php?id=<?php echo $ticket['id']; ?>">
													<span class="fas fa-pencil-alt"></span>
												</a>
												<button class="btn btn-danger text-nowrap" type="read" name="delete" value='<?php echo $ticket['msgid']; ?>' data-confirm="Sure you want to delete the ticket? <br> The ticket replies will be lost!">
													<span class="fas fa-trash"></span>
												</button>
											</div>
										</form>
									</td>
								</tr>
					<?php
							endwhile;
						endif;
					?>
					</tbody>
				</table>
			
			</div>
			
			<?php $nav->pages(); ?>
			
		</div>
	</div>
	<!-- /top tiles -->
</div>

<?php include 'footer.php'; ?>