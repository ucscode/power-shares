<?php

require __dir__ . '/sub-config.php';

include 'inc/for-user-edit.php';

include 'header.php';

?>

<div class="card">
   
	<h4 class="card-header">
		INVESTORS MANAGEMENT
	</h4>

	<div class="card-body">

		<?php sysfunc::html_notice( $temp->msg, $temp->status ?? null ); ?>

		<?php 
			if( !empty($user) ): 
				
				$inputs = array();
				
				//label, name, type, value(s)
				
				$inputs[] = ["Username", 'username', 'text', $user['username'], 'readonly'];
				$inputs[] = ["Email Address", 'email', 'email', $user['email']];
				$inputs[] = ["Balance (USD)", 'walletbalance', 'number', $user['walletbalance'], "step='0.01'"];
				
				$inputs[] = ["E-Mail Confirmation", 'confirm', 'select', array('Unconfirmed', 'Confirmed'), $user['confirm']];
				//$inputs[] = ["RefCode", 'refcode', 'text', $user['refcode']];
				$inputs[] = ["Phone", 'phone', 'text', $user['phone']];
				$inputs[] = ["Address", 'address', 'text', $user['address']];
				
				$inputs[] = ["Country", 'country', 'select', sysfunc::countries(), $user['country']];
		
		?>

			<div class='row'>
				<div class='col-xl-7 mb-5'>
				
					<form method="POST">
						<input type='hidden' name='id' value='<?php echo $user['id']; ?>'>
						<?php
							foreach( $inputs as $data ):
						?>
							<div class='form-group'>
								<label class='form-label'><?php echo $data[0]; ?></label>
								<?php if( $data[2] == 'select' ): ?>
									<select name='<?php echo $data[1]; ?>' class='form-control'>
										<?php 
											foreach( $data[3] as $key => $value ):
												$selected = ($key == ($data[4] ?? null)) ? 'selected' : '';
										?>
											<option value='<?php echo $key; ?>' <?php echo $selected; ?>>
												<?php echo $value; ?>
											</option>
										<?php endforeach; ?>
									</select>
								<?php else: ?>
									<input type='<?php echo $data[2]; ?>' name='<?php echo $data[1]; ?>' value='<?php echo $data[3]; ?>' <?php echo $data[4] ?? null; ?> class='form-control'>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
						
						<div class='form-group'>
							<label class='form-label'>Password</label>
							<div class='alert alert-info fs-13'>
								Leave blank to avoid changing the user's password
							</div>
							<input type='text' name='password' class='form-control'>
						</div>
						
						<div class=''>
							<button class='btn btn-outline-info btn-fw w-100'>
								Update
							</button>
						</div>
					</form>
			
				</div>
				<div class='col-xl-5'>
				
					<div class='border p-3 shadow-sm'>
						<h6 class='poppins text-end'>Investor Info</h6>
						<hr>
						<div class='table-responsive'>
							<table class='table table-bordered table-striped'>
								<tbody>
									<tr>
										<td>Deposits</td>
										<td>
											$<?php 
												echo sysfunc::sum('transactions', 'usd', "
													userid = {$user['id']} 
													AND request = 'deposit' 
													GROUP BY userid"
												); 
											?>
										</td>
									</tr>
									<tr>
										<td>Shares</td>
										<td>
											<?php 
												$result = $link->query( sQuery::select( 'investments', "userid = {$user['id']}" ) );
												echo $result->num_rows;
											?>
										</td>
									</tr>
									<tr>
										<td>Investments</td>
										<td>$<?php echo shares::total( $user['id'], 'amount' ); ?></td>
									</tr>
									<tr>
										<td>ROI</td>
										<td>$<?php echo shares::total( $user['id'], 'increased_usd' ); ?></td>
									</tr>
									<tr>
										<td>Withdrawals</td>
										<td>
											$<?php 
												echo sysfunc::sum('transactions', 'usd', "
													userid = {$user['id']} 
													AND request = 'withdrawal' 
													GROUP BY userid"
												); 
											?>
										</td>
									</tr>
									<tr>
										<td>RefCode</td>
										<td><?php echo $user['refcode']; ?></td>
									</tr>
									<tr>
										<td>Registered</td>
										<td><?php echo $user['date']; ?></td>
									</tr>
									<tr>
										<td>Online</td>
										<td><?php echo empty(user::get($user, 'online')) ? 'No' : "Yes"; ?></td>
									</tr>
									<tr>
										<td>Downlines</td>
										<td><?php echo (user::get($user, 'downlines'))->num_rows; ?></td>
									</tr>
									<tr>
										<td>Sponsor</td>
										<td><?php 
											$sponsor = user::get($user,  'upline');
											if( $sponsor ):
										?>
										<a href='?id=<?php echo $sponsor['id']; ?>'>
											<?php echo $sponsor['username']; ?>
										</a>
										<?php else: ?>
										<i class='fas fa-question-circle text-muted'></i>
										<?php endif; ?></td>
									</tr>
									<tr>
										<td>Ref Bonus</td>
										<td>$<?php echo $user['refbonus']; ?></td>
									</tr>
									<tr>
										<td>Last Seen</td>
										<td><?php echo $user['last_seen']; ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				
				</div>
			</div>

		<?php else: ?>

			<div class='border py-5 m-auto mx-md-5'>
				<div class='text-center text-uppercase'>
					<h1>No user data was found</h1>
					<a href='users-manager.php' class='btn btn-primary'>Back to list</a>
				</div>
			</div>

		<?php endif; ?>

	</div>
</div>



<?php include 'footer.php'; ?>