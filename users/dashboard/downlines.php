<?php

require __dir__ . '/sub-config.php';

include 'header.php';

?>

<?php section::title( "My Downlines", false ); ?>

<div class="card">
	<div class='card-body'>

		<?php sysfunc::html_notice( $msg ?? null ); ?> 
	
		<div class="row">
			
			<div class="col-md-12 col-sm-12 col-sx-12">
			
				<div class="table-responsive">
					<table class="display table table-hover"  id="example">
						<thead>
							<tr class="info">
								<th>Email</th>
								<th>Username</th>
								<th>Ref-Code</th>
								<th>Registered Date</th>
								<th>Country</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							
								$SQL = "
									SELECT * FROM users 
									WHERE referrer = '{$__user['id']}'
									ORDER BY id DESC
								";
								
								$nav = new nav($SQL);
								
								$result = $nav->result();
								
								if(mysqli_num_rows($result) > 0):
									while($row = mysqli_fetch_assoc($result)): 

								 ?>
							<tr class="primary">
								<td><?php echo $row['email'];?></td>
								<td><?php echo $row['username'];?></td>
								<td><?php echo $row['refcode'];?></td>
								<td><?php echo $row['date'];?></td>
								<td><?php echo sysfunc::countries($row['country']);?></td>
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
		
	</div>
</div>

<?php include 'footer.php'; ?>