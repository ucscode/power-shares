<?php

require_once __dir__ . '/sub-config.php';

require_once 'header.php';

$nav = new nav( sQuery::select('transactions', "userid = '{$__user['id']}' ORDER BY id DESC") );

$trans = $nav->result();

section::title("transactions");

?>

	<div class="card">
        <div class="card-body">
            <h4 class="card-title">History</h4>
			<div class='table-responsive'>
				<table class="table table-bordered table-hover text-capitalize">
					<thead>
						<tr>
							<th> # </th>
							<th> Type </th>
							<th> Amount </th>
							<th> Coin </th>
							<th> Status </th>
							<th> Reference ID</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							while( $tx = $trans->fetch_assoc() ):
							
								$icon = $tx['request'] == 'deposit' ? 'mdi mdi-arrow-bottom-right text-primary' : 'mdi mdi-call-missed text-danger';
								
								$color = sysfunc::color($tx['status']);
								
								$tx_url = sysfunc::tx_url($tx['network'], $tx['txid']);
						?>
						<tr>
							<td> <i class='<?php echo $icon; ?>'></i> </td>
							<td> <?php echo $tx['request']; ?> </td>
							<td> <?php echo '$' . $tx['usd']; ?> </td>
							<td> <?php echo trim( $tx['network'] ); ?> </td>
							<td> 
								<label class="badge badge-<?php echo $color; ?>">
									<?php echo $tx['status']; ?>
								</label> 
							</td>
							<td class='text-lowercase'> 
								<a href='<?php echo $tx_url; ?>' <?php if( !empty($tx['txid']) ) echo "target='_blank'"; ?> class='text-decoration-none'>
									<?php echo $tx['reference_id']; ?> <i class='mdi mdi-launch'></i>
								</a>
							</td>
						</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
			
			<?php $nav->pages(); ?>
			
		</div>
	</div>

<?php require_once 'footer.php'; ?>