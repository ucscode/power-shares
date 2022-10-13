<?php

require __dir__ . '/sub-config.php';

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$SQL = "DELETE FROM transactions WHERE id = {$_POST['id']}";
	$temp->status = $link->query( $SQL );
	$msg = ($temp->status) ? "Withdrawal successfully deleted" : "Withdrawal not deleted";
};

include 'header.php';

?>

<div class="card">

	<h5 class="card-header mb-0">
		WITHDRAWAL MANAGEMENT
	</h5>

	<div class="card-body">

		<?php sysfunc::html_notice( $msg, $temp->status ?? null ); ?>

		<div class="p-1">
			<div class="table-responsive">
				<table class="table table-striped table-bordered"  id="example">
					<thead>
						<tr class="info">
							<th>Beneficiary</th>
							<th>Amount</th>
							<th>Network</th>
							<th>Status</th>
							<th>Reference ID</th>
							<th>Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php 

						$SQL = "
							SELECT 
								transactions.*, 
								users.username,
								users.email
							FROM transactions
							LEFT JOIN users
								ON transactions.userid = users.id
							WHERE transactions.request <> 'deposit'
							ORDER BY transactions.id DESC
						";
						
						$nav = new nav($SQL);
						
						$result = $nav->result();

						if(mysqli_num_rows($result)):
							while($tx = mysqli_fetch_assoc($result)): 
								
								$color = sysfunc::color( $tx['status'] );
								
					?>
						<tr class="primary">
							<td>
								<?php if( !empty($tx['username']) ): ?>
									<a href='user-edit.php?email=<?php echo $tx['email']; ?>'>
										<?php echo $tx['username'];?>
									</a>
								<?php else: ?>
									<span class='text-muted'><?php echo $USER_OFF; ?></span>
								<?php endif; ?>
							</td>
							<td>$<?php echo $tx['usd'];?></td>
							<td><?php echo $tx['network'];?></td>
							<td>
								<label class='badge badge-<?php echo $color; ?>'>
									<?php echo $tx['status']; ?>
								</label>
							</td>
							<td>
								<a href='<?php echo sysfunc::tx_url( $tx['network'], $tx['txid'] ); ?>' target='_blank'>
									<?php echo $tx['reference_id'];?>
								</a>
							</td>
							<td><?php echo $tx['date'];?></td>
							<td>
								<form method="post">
									<input type="hidden" name="id" value="<?php echo $tx['id'];?>">
									<div class='btn-group'>
										<a href='withdraw-manager.php?id=<?php echo $tx['id']; ?>' class="btn btn-info">
											<span class="fas fa-pencil-alt"></span>
										</a>
										<button type="submit" class="btn btn-danger" data-confirm="Sure you want to delete the withdrawal?">
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