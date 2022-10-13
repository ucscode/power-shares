<?php

require __dir__ . '/sub-config.php';

$_POST = sysfunc::sanitize_input($_POST);

if($_SERVER['REQUEST_METHOD'] == 'POST' ) {

	$data = array(
		"userid" => $__user['id'],
		"title" => $_POST['title'],
		"message" => $_POST['message'],
		"msgid" => strtolower(sysfunc::keygen(7))
	);
	
	$duplicate = $link->query( "
		SELECT * FROM tickets 
		WHERE userid = '{$__user['id']}' 
			AND title = '{$data['title']}' 
			AND message = '{$data['message']}'
	" )->num_rows;
	
	if( $duplicate ) $response = ["Error: Duplicate Ticket Message", false];
	else {
		if( empty($data['title']) || empty($data['message']) ) $response = ["Message not sent! All fields are required", false];
		else {
			$SQL = sQuery::insert( 'tickets', $data );
			if( mysqli_query($link, $SQL) ) 
				$response = ["
					Your ticket was successfully created! <br>
					Ticket ID: {$data['msgid']} <hr>
					We will attend to your query within 24 hours
				", true];
			else $response = ["Cannot send message!", false];
		};
	};
	
} else $response = [];

include "header.php";

?>

<?php section::title( "New Ticket", false ); ?>


<div class="row">
	<div class="col-md-12 col-sm-12 col-sx-12">
		<div class="card">

			<div class='card-body'>
			
				<?php sysfunc::html_notice( $response[0] ?? null, $response[1] ?? null ); ?>
				
				<form method="POST" enctype="multipart/form-data"  class="form-horizontal form-label-left" >
					
					<div class="item form-group">
						<div class="">
							<input type="text" name="title"  class="form-control"  placeholder="Message title" required>
						</div>
					</div>
					<div class="item form-group">
						<div class="">
							<textarea placeholder="write message here" name="message" class="form-control" rows='9' required></textarea>
						</div>
					</div>
					<div class="col-md-6 ">
						<button type="submit"  class="btn btn-info" >Send Message</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<?php include 'footer.php'; ?>   
