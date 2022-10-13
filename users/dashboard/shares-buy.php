<?php

require __dir__ . '/sub-config.php';

require 'inc/for-shares-buy.php';
	
include "header.php";



?>

<?php section::title( "Buy Shares" ); ?> 

<?php section::show_user_balance(); ?>

<?php sysfunc::html_notice( $temp->msg, $temp->status ?? null ); ?>

<div class="row">
	
    <?php
	
        $SQL = "
			SELECT * FROM shares 
			WHERE status = 1
			ORDER BY id DESC
		";
		
        $result = $link->query($SQL);
		
        if ($result->num_rows):
			
			$index = -1;
			
			while($share = $result->fetch_assoc()):
				
				$index++;
				$position = $index % 3;
				
				if( $position == 2 ) $color = 'danger';
				else if( $position ) $color = 'primary';
				else $color = 'info';
				
				
				$seperator = "<i class='mdi mdi-chevron-double-right'></i>";
				
				$max_invest = empty($share['max_investment']) ? "Unlimited" : "\${$share['max_investment']}";
				$period = empty($share['duration']) ? "Unlimited" : "{$share['duration']} days";
				$bonus = empty($share['bonus']) ? "<i class='mdi mdi-alert-circle-outline'></i>" : "\${$share['bonus']}";
				
	?>
			
			<div class="col-md-6 col-xl-4 col-12 mb-4">
				<div class="card">
					<div class="card-body text-capitalize">
						<h3 class='card-title d-flex align-items-center'>
							<span class='d-block me-3'> 
								<i class='fas fa-gem text-<?php echo $color; ?>'></i> 
							</span>
							<span class='d-block poppins'> 
								<?php echo $share['name']; ?> 
							</span>
						</h3>
						<hr>
						<div class='text-center my-3'>
							<h1 class='text-center poppins mb-1'>
								<span class='fw-900 text-info'><?php echo $share['increase']; ?></span>
								<span class='text-warning'>%</span>
							</h1>
							<h4 class='poppins'>Daily</h4>
						</div>
						<div class='border rounded p-4 mb-3'>
							<ul class="list-star mb-0">
								<li><?php echo "MIN {$seperator} \${$share['min_investment']}"; ?></li>
								<li><?php echo "MAX {$seperator} {$max_invest}"; ?></li>
								<li><?php echo "Period {$seperator} {$period}"; ?></li>
								<li><?php echo "Bonus {$seperator} {$bonus}"; ?></li>
							</ul>
						</div>
						<div class=''>
							<form method='post'>
								<div class='mb-2'>
									<input class='form-control' type='number' step='0.01' name='amount' value='' placeholder='Enter amount' required>
								</div>
								<input type='hidden' name='id' value='<?php echo $share['id']; ?>'>
								<button class='btn btn-outline-<?php echo $color; ?> btn-fw w-100' type='submit'>
									Buy Share
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			
	<?php  
			endwhile;
			
        else:
	?>
		
			<div class='col-md-12'>
				<div class='card'>
					<div class='card-body text-center'>
						<div class=''>
							<img src='images/basic/error-monitor.jpg' width="400px" class='img-fluid'>
						</div>
						<hr>
						<h2 class='text-uppercase'>No Shares Available</h2>
						<p>
							<i class='fas fa-info-circle me-1'></i> 
							<span class='text-danger'>Please check back later</span>
						</p>
					</div>
				</div>
			</div>
			
    <?php endif; ?>
		
</div>


<?php include 'footer.php'; 