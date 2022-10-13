<?php

require __dir__ . '/sub-config.php';

$MINI_SQL = "
	SELECT 
		transactions.*,
		users.username,
		users.email,
		users.walletbalance,
		users.country
	FROM transactions
	LEFT JOIN users
		ON transactions.userid = users.id
";
								
if( $_SERVER['REQUEST_METHOD'] == 'POST' ) include 'inc/for-deposit.php';

include 'header.php';

?>


	<div class="card">
	
		<div class="card-header">
            <h5 class="mb-0">
				INVESTORS DEPOSIT
			</h5>
		</div>
		
		<div class='card-body'>
		
			<?php sysfunc::html_notice($temp->msg, $temp->status ?? null); ?>
			
			 <div class="row">
				<div class="col-md-12 col-sm-12 col-sx-12">
				   <div class="table-responsive">
					  <table class="table table-bordered table-hover"  id="example">
						 <thead>
							<tr class="info">
								<th class='d-none'>FORM</th>
								<th>Investor</th>
								<th>Amount</th>
								<th>Rate</th>
								<th>Network</th>
								<th>Status</th>
								<th>Reference ID</th>
								<th>Approval</th>
								<th>Trash</th>
							</tr>
						 </thead>
						 <tbody>
							<?php 
								
								$nav = new nav( $MINI_SQL . "WHERE transactions.request = 'deposit' ORDER BY transactions.id DESC" );
								
								$result = $nav->result();
								
								if(mysqli_num_rows($result)):
									while($tx = mysqli_fetch_assoc($result)):   
							   
										$color = sysfunc::color( $tx['status'] );
										$form_id = "form-{$tx['id']}";
										$tx_url = sysfunc::tx_url( $tx['network'], $tx['txid'] );
									   
								?>
							<!------------- start -------------->
							<tr class="primary">
								<td class='d-none'>
									<!-- [tr form] -->
									<form method='post' id='<?php echo $form_id; ?>' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
										<input type="hidden" name="id" value="<?php echo $tx['id'];?>">
									</form>
								</td>
								<td>
									<?php if( !empty($tx['username']) ): ?>
									<a href='user-edit.php?id=<?php echo $tx['userid']; ?>'>
										<?php echo $tx['username'];?>
									</a>
									<?php else: ?>
										<span class='text-muted'><?php echo $USER_OFF; ?></span>
									<?php endif; ?>
								</td>
								<td><?php echo '$' . $tx['usd'];?></td>
								<td><?php echo $tx['coin_rate'];?>  </td>
								<td><?php echo $tx['network'];?></td>
								<td>
									<label class='badge badge-<?php echo $color; ?>'>
										<?php echo $tx['status']; ?>
									</label>
								</td>
								<td>
									<a href='<?php echo $tx_url; ?>' target='_blank'>
										<?php echo $tx['reference_id'];?> <i class='mdi mdi-launch'></i>
									</a>
								</td>
								<td>
									<div class='btn-group'>
										<button class="btn btn-success" type="submit" name='action' value="approve" title='approve' form='<?php echo $form_id; ?>' data-confirm='Approve Deposit? <?php if(empty($tx['paid'])) echo "<br> User will be funded (\${$tx['usd']})!"; ?>'>
											<i class="fa fa-check"></i>
										</button>
										<button class="btn btn-warning" type="submit" name='action' value="decline" title='decline' form='<?php echo $form_id; ?>' data-confirm='Disapprove Deposit?'>
											<i class="fa fa-ban"></i> 
										</button>
									</div>
								</td>
								<td> 
									<button class="btn btn-danger" type="submit" name='action' value="delete" title='delete' form='<?php echo $form_id; ?>' data-confirm='Are you sure you want to delete this deposit?'>
										<i class="fa fa-trash"></i>
									</button>
								</td>
							</tr>
							<!-------------------- end ------------------->
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