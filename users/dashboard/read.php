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

<?php section::title( "View Admin Messages", false ); ?>

<div class="card" style="margin-top:50px">
    
	<h2 class="text-center card-header">MESSAGE MANAGEMENT</h2>
	
	<div class='card-body'>
	
		<?php sysfunc::html_notice( $msg ?? null ); ?>
			
		<div class="row row-card-no-pd mt--2">
			<div class="col-md-12 col-sm-12 col-sx-12">
				<div class="table-responsive">
					<table class="display table table-striped"  id="example">
						<thead>
							<tr class="info">
								<th>Email</th>
								<th>Message</th>
								<th style="display:none;"></th>
								<th>Title</th>
								<th>Status</th>
								<th>Date</th>
								<th>Action</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							
								$sql= "
									SELECT * FROM 
									adminmessage WHERE email='{$__user['email']}'
								";
								
								$result = mysqli_query($link,$sql);
								
								if(mysqli_num_rows($result)):
									while($row = mysqli_fetch_assoc($result)):
									 
										if(!empty($row['status'])) $msg = 'Message Read <i class="fa fa-check-circle text-success fs-19" ml-1"></i>';
										else $msg = 'New Message! <i class="fa fa-envelope text-danger fs-19 ml-1"></i>';
										
								?>
							<tr class="primary">
								<form action="read.php" method="post">
									<td><?php echo $row['email'];?></td>
									<td id="email"><?php echo $row['message'];?></td>
									<td style="display:none;"><input type="hidden" name="msgid" value="<?php echo $row['msgid'];?>"> </td>
									<td><?php echo $row['title'];?></td>
									<td><?php echo $msg;?></td>
									<td><?php echo $row['date'];?></td>
									<td>
										<button class="btn btn-success text-nowrap" type="read" name="read">
											<span class="glyphicon glyphicon-check"> Mark as read</span>
										</button>
									</td>
								</form>
								<form action='read.php' method='post' onsubmit="return confirm('Confirm message delete');">
									<td>
										<input type='hidden' name='msgid' value='<?php echo $row['msgid']; ?>'>
										<button type="submit" name="delete" class="btn btn-danger">
											<span class="glyphicon glyphicon-trash"> Delete</span>
										</button>
									</td>
								</form>
							</tr>
							<?php
										endwhile;
								endif;
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- /top tiles -->
	</div>
	
</div>

<?php include 'footer.php'; ?>   
