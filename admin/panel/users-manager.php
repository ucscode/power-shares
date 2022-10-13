<?php

require __dir__ . '/sub-config.php';

include 'inc/for-user-manager.php';

include 'header.php';

?>

<div class="card">
	<h4 class="card-header">
		INVESTORS MANAGEMENT
	</h4>
	<div class="card-body">
	
		<?php sysfunc::html_notice( $msg, $temp->status ?? null ); ?>
		
		<div class="">
			<div class="table-responsive">
				<table class="table display table-striped table-bordered text-center ">
					<thead>
						<tr class="info">
							<th>Username</th>
							<th>Email</th>
							<th>Avatar</th>
							<th>Downlines</th>
							<th>Investments</th>
							<th>ROI</th>
							<th>Balance</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						
							$nav = new nav("SELECT * FROM users ORDER BY id DESC");
							
							$result = $nav->result();
							
							if(mysqli_num_rows($result)):
								while($user = mysqli_fetch_assoc($result)): 
									
									$refs = ( user::get($user, 'referrals') )->num_rows;
									
						?>
						<tr class="primary">
							<td>
								<a href='user-edit.php?id=<?php echo $user['id']; ?>'>
									<?php echo $user['username']; ?>
								</a>
							</td>
							<td ><?php echo sysfunc::checker($user['confirm']); ?></td>
							<td><img src="<?php echo user::get($user, 'avatar'); ?>" width="50px" class='img-fluid'></td>
							<td><?php echo $refs; ?></td>
							<td><?php echo '$' . round(shares::total($user['id'], 'amount'), 2); ?></td>
							<td><?php echo '$' . round(shares::total($user['id'], 'increased_usd'), 2); ?></td>
							<td><?php echo '$' . round($user['walletbalance'], 2); ?></td>
							<td>
								<form method='POST'>
									<input type='hidden' name='id' value='<?php echo $user['id']; ?>'>
									<div class='btn-group'>
										<a class="btn btn-primary text-nowrap" href='user-edit.php?id=<?php echo $user['id']; ?>' title="Edit User">
											<i class='fas fa-pencil-alt'></i>
										</a>
										<button class='btn btn-danger' name='action' value='delete' data-confirm='(<?php echo $user['username']; ?>) <br> Sure you want to delete the user?'>
											<i class='fas fa-trash'></i>
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