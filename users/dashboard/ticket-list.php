<?php

require __dir__ . '/sub-config.php';

$_POST = sysfunc::sanitize_input($_POST);

// delete investor
if(isset($_POST['delete'])){
	$msgid = $_POST['msgid'];
	$sql = "DELETE FROM adminmessage WHERE msgid='$msgid'";
	$msg = (mysqli_query($link, $sql)) ? "Message deleted successfully!" : "Message not deleted! ";
};


// verify investor

if(isset($_POST['read'])){
	$msgid = $_POST['msgid'];
	$sql = "UPDATE adminmessage SET status = '1'  WHERE msgid='$msgid'";
	$msg = (mysqli_query($link, $sql)) ? "Message marked as read!" : "Message not marked  ";
}

include 'header.php';

?>

<?php section::title( "Ticket List", false ); ?>

<div class="card">
	<div class='card-body'>
	
		<?php sysfunc::html_notice( $msg ?? null ); ?>
			
		<div class="row">
			<div class="col-md-12 col-sm-12 col-sx-12">
				<div class="table-responsive">
					<table class="display table table-striped"  id="example">
						<thead>
							<tr class="info">
								<th>T:ID</th>
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
									SELECT * FROM tickets
									WHERE userid = '{$__user['id']}'
									ORDER BY id DESC
								";
								
								$nav = new nav($SQL);
								
								$result = $nav->result();
								
								if(mysqli_num_rows($result)):
									while($ticket = mysqli_fetch_assoc($result)):
										
										$color = sysfunc::color( $ticket['status'] );
										$replies = $link->query( sQuery::select( 'ticket_replies', "msgid = '{$ticket['msgid']}'" ) )->num_rows;
										
								?>
							<tr class="primary">
								<td><?php echo $ticket['msgid'];?></td>
								<td><?php echo $ticket['title'];?></td>
								<td><?php echo $ticket['date'];?></td>
								<td><label class='badge badge-<?php echo $color; ?>'><?php echo $ticket['status']; ?></label></td>
								<td><?php echo $replies; ?></td>
								<td>
									<form method='post'>
										<input type='hidden' name='msgid' value='<?php echo $ticket['msgid']; ?>'>
										<div class='btn-group'>
											<a class="btn btn-success" href='ticket-reply.php?id=<?php echo $ticket['msgid']; ?>' title='conversation'>
												<span class="mdi mdi-comment-multiple-outline"></span>
											</a>
											<button type="submit" <?php echo ($ticket['status'] != 'pending' || !empty($replies)) ? "disabled" : 'name="delete"'; ?> class="btn btn-danger" title='delete'>
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
</div>

<?php include 'footer.php'; ?>   
