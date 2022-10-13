<?php

require __dir__ . '/sub-config.php';

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	
	$temp->status = $usermeta->set("kyc_status", $_POST['kyc'], $_POST['id']);
	$temp->msg = ($temp->status) ? "KYC Successfully {$_POST['kyc']}" : "KYC not {$_POST['kyc']}";
	
};

include 'header.php';

?>
  

    <div class="card">
		<h5 class="card-header">
			INVESTORS
		</h5>
		<div class="card-body">
		
			<?php sysfunc::html_notice( $temp->msg, $temp->status ?? null ); ?>
			
			<div class="">
				<div class="table-responsive">
					<table class="table display table-striped table-bordered" data-table="expanded">
						<thead>
							<tr class="info">
								<th>Username</th>
								<th>Email</th>
								<th>Balance</th>
								<th>Online</th>
								<th>RegDate</th>
								<th>Country</th>
								<th colspan='2'>KYC</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								
								$nav = (new nav("SELECT * FROM users ORDER BY id DESC"));
								
								$result = $nav->result();
								
								if(mysqli_num_rows($result)):
								
									while($user = mysqli_fetch_assoc($result)): 
									
										$msg = !empty(user::get($user, 'online')) ? "<span class='text-success'>Yes</span>" : "<span class='text-danger'>No</span>";
										
										$kyc = $usermeta->get('kyc_status', $user['id']);
										
										if( is_null($kyc) ) $kyicon = "<i class='fas fa-ban text-info' title='No KYC'></i>";
										else {
											switch( $kyc ) {
												case 'pending':
														$kyicon = "<i class='fas fa-question-circle text-warning' title='KYC Pending'></i>";
													break;
												case 'declined':
														$kyicon = "<i class='fas fa-exclamation-circle text-danger' title='KYC Declined'></i>";
													break;
												default:
													$kyicon = "<i class='fas fa-check text-success' title='KYC Approved'></i>";
											};
										};
										
										$disabled = is_null($kyc) ? 'disabled' : null;
										
							?>
							<tr class="primary">
								<td>
									<a href='user-edit.php?id=<?php echo $user['id']; ?>'>
										<?php echo $user['username']; ?>
									</a>
								</td>
								<td><?php echo $user['email']; ?></td>
								<td>$<?php echo round($user['walletbalance'], 2); ?></td>
								<td><?php echo $msg; ?></td>
								<td><?php echo $user['date']; ?></td>
								<td><?php echo sysfunc::countries($user['country']); ?></td>
								<td><?php echo $kyicon; ?></td>
								<td>
									<form method='POST'>
										<input type='hidden' name='id' value='<?php echo $user['id']; ?>'>
										<div class='btn-group'>
											<button class='btn btn-success' title='Approve KYC' <?php echo $disabled; ?> data-confirm="Approve KYC?" name='kyc' value='approved'>
												<i class='fas fa-check'></i>
											</button>
											<button class='btn btn-danger' title='Decline KYC' <?php echo $disabled; ?> data-confirm="Disapprove KYC?" name='kyc' value='declined'>
												<i class='fas fa-times'></i>
											</button>
											<a class='btn btn-info kyc-pop' title='KYC DOCUMENT' <?php echo $disabled; ?> href='<?php echo sysfunc::url( __users_contents . '/images/verify/' . $usermeta->get('kyc_document', $user['id']) ); ?>'>
												<i class='fas fa-eye'></i>
											</a>
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
	
	<?php events::addListener('@footer', function() { ?>
		<script>
			$(".kyc-pop").magnificPopup({
				type: 'image',
				mainClass: 'mfp-with-zoom'
			});
		</script>
	<?php }); ?>
	
<?php require 'footer.php'; ?>