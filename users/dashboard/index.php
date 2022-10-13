<?php

require __dir__ . '/sub-config.php';

require_once __dir__ . '/sections/frontend.php';

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	
	$_POST = sysfunc::sanitize_input( $_POST, true );
	$_POST['userid'] = $__user['id'];
	$_POST['display_name'] = $__user['username'];
	
	$SQL = sQuery::select( 'testimonials', "userid = {$__user['id']} AND message = '{$_POST['message']}'" );
	$duplicate = $link->query( $SQL )->num_rows;
	
	if( !$duplicate ) {
		
		$SQL = sQuery::insert( 'testimonials', $_POST );
		
		$temp->status = $link->query( $SQL );
		$temp->msg = ( $temp->status ) ? "Your testimonials is under review" : "An error occured! <br> Testimonial not modified";
	
	} else $temp->status = !($temp->msg = "The testimonials has already been submitted");
	
};

events::addListener('@header', function() {
	echo "<style>
		.nomics-ticker-widget,
		.nomics-ticker-widget-embedded { 
			margin: auto; 
		}
	</style>";
});

include "header.php";

?>

	<div class='row'>
	
		<div class='col-md-12 grid-margin stretch-card'>
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">BTC Rate</h4>
					<div class="nomics-ticker-widget" data-name="Bitcoin" data-base="BTC" data-quote="USD"></div>
				</div>
			</div>
		</div>
		
		<?php 
			$main_banner = $config->get('main_banner_code');
			if( !empty($main_banner) ):
		?>
			<div class='col-md-12 mb-3'>
				<div class='text-center overflow-auto'>
					<?php echo $main_banner; ?>
				</div>
			</div>
		<?php endif; ?>
		
	</div>

	<!------------------------------------------------------>
	
	<div class='row mb-3'>
	
		<div class='col-md-8 col-lg-12 col-xl-9 grid-margin'>
			<div class='row text-center'>
				<div class='col-sm-6 col-lg-4 mb-2'>
					<div class="card">
					  <div class="card-body">
						<h1 class='overview-icon text-info'>
							<i class="mdi mdi-coin"></i>
						</h1>
						<p>Balance</p>
						<h2 class='text-dark'>$<?php echo number_format($__user['walletbalance'], 2); ?></h2>
					  </div>
					</div>
				</div>
				<div class='col-sm-6 col-lg-4 mb-2'>
					<div class="card">
					  <div class="card-body">
						<h1 class='overview-icon text-warning'>
							<i class="mdi mdi mdi-checkbox-multiple-marked-circle-outline"></i>
						</h1>
						<p>Shares</p>
						<h2 class='text-dark'>$<?php echo shares::total( $__user['id'], 'amount', 'status = 1' ); ?></h2>
					  </div>
					</div>
				</div>
				<div class='col-sm-6 col-lg-4 mb-2'>
					<div class="card">
					  <div class="card-body">
						<h1 class='overview-icon text-primary'>
							<i class="mdi mdi-arrow-top-right"></i>
						</h1>
						<p>Increase</p>
						<h2 class='text-success'><?php echo shares::total( $__user['id'], 'increase', 'status = 1' ); ?><sup class='poppins'>%</sup></h2>
					  </div>
					</div>
				</div>
				<div class='col-sm-6 col-lg-4 mb-2'>
					<div class="card">
					  <div class="card-body">
						<h1 class='overview-icon text-info'>
							<i class="mdi mdi-buffer"></i>
						</h1>
						<p>Total Profit</p>
						<h2 class='text-dark'>$<?php echo shares::total( $__user['id'], 'increased_usd' ); ?></h2>
					  </div>
					</div>
				</div>
				<div class='col-sm-6 col-lg-4 mb-2'>
					<div class="card">
					  <div class="card-body">
						<h1 class='overview-icon text-warning'>
							<i class="mdi mdi-account-star"></i>
						</h1>
						<p>Referral Bonus</p>
						<h2 class='text-dark'>$<?php echo $__user['refbonus']; ?></h2>
					  </div>
					</div>
				</div>
				<div class='col-sm-6 col-lg-4 mb-2'>
					<div class="card">
					  <div class="card-body">
						<h1 class='overview-icon text-primary'>
							<i class="mdi mdi-format-horizontal-align-right"></i>
						</h1>
						<p>Withdrawal</p>
						<h2 class='text-dark'>
							$<?php 
								echo sysfunc::sum('transactions', 'usd', "
									userid = {$__user['id']} 
									AND request = 'withdrawal'
									GROUP BY userid
							"); ?>
						</h2>
					  </div>
					</div>
				</div>
			</div>
		</div>
		
		<div class='col-md-4 col-lg-4 col-xl-3 grid-margin'>
			<div class='card text-center'>
				<div class='card-body'>
					<h4 class=''>Invite Friends</h4>
					<img src='images/basic/jssocial.jpg' class='img-fluid' style='width: 270px;'>
					<div id='jssocials'></div>
				</div>
			</div>
			<div class='card d-none'>
				<div class='card-body'>
					<div class="row">
						<div class='col-sm-6 col-xl-12 mb-1'>
							<h4>Invite Friends On:</h4>
							<div class='p-2'>
							</div>
						</div>
						<div class='col-sm-6 col-xl-12 mb-1'>
							<div class='p-2 border'>
								Reg: 22 dec
							</div>
						</div>
						<div class='col-sm-6 col-xl-12 mb-1'>
							<div class='p-2 border'>
								IP: 127.0.0.1 
							</div>
						</div>
						<div class='col-sm-6 col-xl-12 mb-1'>
							<div class='p-2 border'>
								Last Access: Dec 22
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class='col-md-6 col-lg-8 col-xl-6 grid-margin'>
			<div class='card'>
				<div class='card-body'>
					<h4 class='card-title'>Testimonial</h4>
					<?php
						$SQL = sQuery::select( 'testimonials', "status = 'approved' ORDER BY stars DESC LIMIT 5" );
						$testimonials = $link->query( $SQL );
						if( $testimonials->num_rows ):
							while( $testimonial = $testimonials->fetch_assoc() ):
								$agent = sysfunc::_data( 'users', $testimonial['userid'] );
								$img = ($agent) ? user::get($agent, 'avatar') : "images/profile/icon.png";
					?>
						<div class="border-bottom mb-3">
							<div class="row">
								<div class="col-4 text-center">
									<div class="icon">
										<img src='<?php echo $img ?>' width='90px' class='img-fluid img-thumbnail mb-1'>
									</div>
									<div class="fw-600"> 
										<?php echo ucwords($testimonial['display_name']); ?>
									</div>
								</div>
								<div class="col-8 content">
									<div>
										<?php 
											for( $x = 1; $x <= 5; $x++ ): 
												$star = ($x <= (int)$testimonial['stars']) ? 'star text-warning' : 'star-outline text-muted';
										?>
										<i class='mdi mdi-<?php echo $star; ?>'></i>
										<?php endfor; ?>
									</div>
									<p><?php echo nl2br($testimonial['message']); ?></p>
								</div>
							</div>
						</div>
					<?php 	
							endwhile;
						else: 
					?>
						<div class='text-center'>
							<img src='images/basic/confirm1.jpg' width='130px' class='img-fluid mb-2'>
							<h3 class=''>No Testimonial Yet</h3>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		
		<div class='col-md-6 col-lg-8 col-xl-6 ms-auto'>
			<div class='card'>
				<div class='card-body'>
					<h4 class='card-title'>Your Testimonial</h4>
					
					<?php sysfunc::html_notice( $temp->msg, $temp->status ?? null ); ?>
					
					<div class='mb-3 fs-13 text-muted'>
						Share your experience with others
					</div>
					<form method='POST'>
						<div class='ratings mb-2 d-flex'>
							<div><i class='far fa-star text-warning me-3'></i></div>
							<div class='stars'>
								<?php
									for( $x = 1; $x <= 5; $x++ ):
										$rate_id = "star-{$x}";
										$checked = ($x == 4) ? 'checked' : null;
								?>
								<div class="form-check form-check-inline d-inline-block">
									<input class="form-check-input" type="radio" name="stars" id="<?php echo $rate_id; ?>" value="<?php echo $x; ?>" <?php echo $checked; ?>>
									<label class="form-check-label" for="<?php echo $rate_id; ?>"><?php echo $x; ?></label>
								</div>
								<?php endfor; ?>
							</div>
						</div>
						<div class=''>
							<textarea class='form-control form-control-lg mb-2' placeholder='Write Here' rows='6' name='message' minlength="60" required></textarea>
							<button class='btn btn-info w-100'>Submit Testimonial</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		
	</div>

<?php include 'footer.php'; ?>

