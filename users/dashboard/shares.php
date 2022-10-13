<?php

require __dir__ . '/sub-config.php';

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	
	$temp->status = shares::finalize($_POST['id']);
	$temp->msg = $temp->status ? "The shared plan was successfully ended" : "Some actions were inaccurate! <br> Please contact our suppor team to resolve any errors";
	
};

include 'header.php';

$SQL = "
	SELECT * FROM investments 
	WHERE userid ='{$__user['id']}'
	ORDER BY id DESC
";

$nav = new nav($SQL);

$result = $nav->result();

?>

<?php section::title( "My Shares" ); ?>

<?php section::show_user_balance( "My Shares" ); ?>

<?php sysfunc::html_notice( $temp->msg, $temp->status ?? null ); ?>

<?php if( $result->num_rows ): ?>
	
	<div class='bg-gray mb-4 p-4 text-white text-center text-uppercase'>
		<div class='row'>
			<div class='col-sm-6 col-md-3'>
				<div class='p-2'>
					<h5>Total Income</h5>
					<h2>$ <?php echo shares::total( $__user['id'], 'increased_usd' ); ?></h2>
				</div>
			</div>
			<div class='col-sm-6 col-md-3'>
				<div class='p-2'>
					<h5>Active Profit</h5>
					<h2>$ <?php echo shares::total( $__user['id'], 'increased_usd', 'status = 1' ); ?></h2>
				</div>
			</div>
			<div class='col-sm-6 col-md-3 d-none d-md-block'>
				<div class='p-2'>
					<h5>Running Plans</h5>
					<h2><?php echo shares::total( $__user['id'], 'status', 'status = 1' ); ?></h2>
				</div>
			</div>
			<div class='col-sm-6 col-md-3 d-none d-md-block'>
				<div class='p-2'>
					<h5>Payments</h5>
					<h2><?php echo shares::total( $__user['id'], 'paid', 'paid = 1' ); ?></h2>
				</div>
			</div>
		</div>
	</div>
		
<?php endif; ?>


<div class='card'>
	<div class='card-body'>
	
	<?php if($result->num_rows): ?>
	
		<div class='table-responsive'>
			<table class='table table-bordered'>
				<thead>
					<th>Title</th>
					<th>Days Used</th>
					<th>Invested</th>
					<th>Received</th>
					<th>Status</th>
					<th>Paid</th>
					<th></th>
				</thead>
				<tbody>
					<?php 
						while($inv = $result->fetch_assoc()):
							   
							$elapsed = (int)((strtotime($inv['last_increase_date']) - strtotime($inv['date'])) / 86400);
							$limit = !empty($inv['duration']) ? null : "<i class='mdi mdi-star-circle text-warning ms-1' title='Unlimited'></i>";
							
					?>
						<tr>
							<td><?php echo $inv['share_name']; ?></td>										
							<td>
								<?php echo "<span class='text-danger'>{$elapsed}</span>"; ?> 
								<span class='text-muted'>days</span>
								<?php echo $limit; ?>
							</td>										
							<td><?php echo '$' . $inv['amount']; ?></td>										
							<td class='text-success'><?php echo '$' . $inv['increased_usd']; ?></td>										
							<td><?php echo sysfunc::checker($inv['status'], 'active', 'ended'); ?></td>										
							<td><?php echo sysfunc::checker($inv['paid'], 'Yes', 'No'); ?></td>										
							<td>
								<form method='post'>
									<input type='hidden' name='id' value='<?php echo $inv['id']; ?>'>
									<button class='btn btn-danger' type='submit' name='action' value='end' data-confirm='Are you sure you want to end the plan? <br> $<?php echo $inv['increased_usd']; ?> USD will be moved to your wallet balance.' <?php if( !empty($inv['paid']) || empty($inv['status']) ) echo 'disabled'; ?>>
										<i class='fas fa-power-off fs-14'></i>
									</button>
								</form>
							</td>										
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		
		<?php $nav->pages(); ?>
		
		<?php else: ?>
	
		<div class='text-center'>
			<img src='images/basic/error-monitor.jpg' class='img-fluid mb-2' width="400px">
			<div class='alert alert-info text-center'> You currently have no share </div>
			<a href='shares-buy.php' class='btn btn-outline-primary btn-fw'>
				Buy Shares
			</a>
		</div>
		
		<?php endif; ?>	
		
	</div>
</div>

<?php include 'footer.php'; ?>