<?php 

require __dir__ . '/sub-config.php';

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	
	$_POST = sysfunc::sanitize_input( $_POST, true );
	
	if( isset($_POST['delete']) ) {
		
		$SQL = "DELETE FROM testimonials WHERE id = {$_POST['id']}";
		$temp->status = $link->query( $SQL );
		$temp->msg = ($temp->status) ? "Testimonial successfully deleted" : "Testimonial not deleted";
		
	} else {
		
		$SQL = sQuery::update( 'testimonials', $_POST, "id = {$_POST['id']}" );
		$temp->status = $link->query( $SQL );
		$temp->msg = $temp->status ? "Testimonial successfully updated" : "Testimonial was not updated";
	
	};
	
};

require 'header.php';

$SQL = "
	SELECT testimonials.*, users.username
	FROM testimonials
	LEFT JOIN users	
		ON testimonials.userid = users.id
	ORDER BY id DESC
";

$nav = new nav($SQL);

$testimonials = $nav->result();

?>

	<?php section::title( 'Testimonials', false ); ?>
	
	<div class='row'>

		<div class='col-xl-9 m-auto'>
		
			<?php sysfunc::html_notice( $temp->msg, $temp->status ?? null ); ?>
			
			<div class='card'>
				<div class='card-body'>
					
					<?php if( !$testimonials->num_rows ): ?>
						
						No Testimonials
					
					<?php else: ?>
						
						<div class='fs-14'>

							<?php 
								while( $testimonial = $testimonials->fetch_assoc() ):
									$color = sysfunc::color( $testimonial['status'] );
									$tid = "review-{$testimonial['id']}";
							?>
								
								<div class='px-2'>
								
									<div class='mb-1 d-flex flex-wrap justify-content-between'>
										<div class=''>
											<i class='mdi mdi-account-circle'></i>
											<?php if( !empty($testimonial['username']) ): ?>
												<a href='user-edit.php?id=<?php echo $testimonial['userid']; ?>'>
													<?php echo $testimonial['username']; ?>
												</a>
											<?php else: ?>
												<span class='text-muted'>UNDEFINED</span>
											<?php endif; ?>
										</div>
										<div class='' title='<?php echo $testimonial['stars'] . " stars"; ?>'>
											<?php 
												for( $x = 1; $x <= 5; $x++ ): 
													$star = $x <= (int)$testimonial['stars'] ? 'star text-warning' : 'star-outline';
											?>
												<i class='mdi mdi-<?php echo $star; ?>'></i>
											<?php endfor; ?>
										</div>
									</div>
									
									<form method='POST'>
									
										<input type='hidden' name='id' value='<?php echo $testimonial['id']; ?>'>
										
										<div class='mb-2'>
											<textarea class='form-control form-control-lg testimony' rows='1' name='message' id='<?php echo $tid; ?>' readonly><?php echo $testimonial['message']; ?></textarea>
										</div>
										
										<div class='d-flex justify-content-between mb-2'>
											<div class='text-capitalize'>
												<i class='mdi mdi-star-circle text-<?php echo $color; ?>'></i>
												<?php echo $testimonial['status']; ?>
											</div>
											<div class='text-muted'><?php echo $testimonial['date']; ?></div>
										</div>
										
										<div class='mb-2 text-center'>
											<?php 
												for( $x = 1; $x <= 5; $x++ ): 
													$checked = ($x == (int)$testimonial['stars']) ? 'checked' : null;
													$rate_id = "r-{$x}-{$testimonial['id']}";
											?>
												<div class="form-check form-check-inline d-inline-block">
													<input class="form-check-input" type="radio" name="stars" id="<?php echo $rate_id; ?>" value="<?php echo $x; ?>" <?php echo $checked; ?>>
													<label class="form-check-label" for="<?php echo $rate_id; ?>"><?php echo $x; ?></label>
												</div>
											<?php endfor; ?>
										</div>
										
										<div class='d-flex flex-wrap justify-content-between'>
											<div class='btn-group'>
												<button type='button' class='btn btn-info' title='edit' data-edit='#<?php echo $tid; ?>'>
													<i class='fas fa-pencil-alt'></i>
												</button>
												<button type='submit' name='delete' class='btn btn-danger' title='delete' data-confirm='Are you sure you want to delete the testimonial?'>
													<i class='fas fa-trash'></i>
												</button>
											</div>
											<div class='text-right'>
												<div class='input-group'>
												<select class='form-select form-select-sm default text-capitalize' name='status'>
													<?php 
														foreach( ['pending', 'approved', 'declined'] as $option ): 
															$selected = ($option == $testimonial['status']) ? 'selected' : null;
													?>
													<option value='<?php echo $option; ?>' <?php echo $selected; ?>>
														<?php echo $option; ?>
													</option>
													<?php endforeach; ?>
												</select>
												<button type='submit' class='btn btn-success' title='save'>
													<i class='fas fa-save'></i>
												</button>
												</div>
											</div>
										</div>
										
									</form>
									
								</div>
								
								<div class='my-4 border-top'></div>
								
							<?php endwhile; ?>
							
						</div>
						
						<?php $nav->pages(); ?>
						
					<?php endif; ?>
					
				</div>
			</div>
		</div>
	
	</div>
	
	<?php events::addListener('@footer', function() { ?>
		<script>
			let x;
			function txtsize() {
				clearTimeout(x);
				$('.testimony').css('height', 'auto');
				x = setTimeout(function() {
					$('.testimony').each(function() {
						$(this).css({
							'height': this.scrollHeight,
							'overflow': 'hidden'
						});
					});
				}, 300);
			}; (txtsize());
			$(window).on('resize', txtsize);
			
			$("[data-edit]").click(function() {
				$(this.dataset.edit).prop('readonly', false);
			});
		</script>
	<?php }); ?>
	
<?php require 'footer.php'; ?>