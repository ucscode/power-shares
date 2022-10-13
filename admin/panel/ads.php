<?php

require __dir__ . '/sub-config.php';

function capture_name($key) {
	$name = str_replace(["_code", "_"], [null, " "], $key);
	return ucwords($name);
};

$response = [];

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	//$_POST['code'] = $link->real_escape_string( $_POST['code'] );
	$name = capture_name($_POST['key']);
	$temp->status = $config->set( $_POST['key'], $_POST['code'] );
	$response[ $_POST['key'] ] = ($temp->status) ? "{$name} code successfully saved" : "{$name} code was not saved";
};

require 'header.php';

?>

	<?php section::title( 'config - ads', false ); ?>
	
	<div class='card'>
		<div class='card-body'>
			
			<?php
				$code_area = array(
					"main_banner_code",
					"header_code",
					"footer_code"
				);
			?>
			
			<div class='form-group'>
				<select class='form-select form-select-lg default text-capitalize' id='banner-switch'>
				<?php 
					foreach( $code_area as $area ):
				?>
					<option value='<?php echo $area; ?>'>
						<?php echo capture_name($area); ?>
					</option>
				<?php endforeach; ?>
				</select>
			</div>
			
			<div class=''>
				
				<div class='mb-4 fs-12'>
					<div class='text-muted mb-1'>You can add multiple ad codes in the Header &amp; Footer area like:</div>
					<div class='ms-4 mb-1'>&lt;script&gt; Adsense Code &lt;script/&gt;</div>
					<div class='ms-4'>&lt;script&gt; PopAds Code &lt;script/&gt;</div>
				</div>
				
				<?php 
					foreach( $code_area as $key => $area ): 
						$name = capture_name($area);
						$display = !empty($key) ? 'd-none' : null;
				?>
					<div class='<?php echo $display; ?>' data-banner='<?php echo $area; ?>'>
						<?php 
							if( array_key_exists($area, $response) ): 
								sysfunc::html_notice( $response[$area], $temp->status ?? null );
							else: 
						?>
							<div class='alert alert-info fs-13'>
								Paste <strong><?php echo $name; ?></strong> Code Below:
							</div>
						<?php endif; ?>
						<form method='POST'>
							<input type='hidden' name='key' value='<?php echo $area; ?>'>
							<textarea class='form-control' name='code' value='<?php echo $name; ?>' placeholder='Paste <?php echo $name; ?> Code Here ...' rows='12'><?php echo $config->get($area); ?></textarea>
							<div class='my-2'>
								<button class='btn btn-info w-100'>
									<i class='fas fa-save'></i> Save Code
								</button>
							</div>
						</form>
					</div>
				<?php endforeach; ?>
			
			</div>
			
			<hr>
			
			<h4 class='poppins text-muted'>
				<i class='far fa-lightbulb me-1'></i> Tips:
			</h4>
			
			<ul class='text-muted'>
				<li>Header code is anything before &lt;/head&gt; tag</li>
				<li>Footer code is anything before &lt;/body&gt; tag</li>
				<li>Main Banner is 720 x 90 banner size</li>
			</ul>
			
		</div>
	</div>

	<?php
		events::addListener('@footer', function() use($response) {
	?>
		<script>
			$('#banner-switch').on('change', function() {
				let container = $("[data-banner='" + this.value + "']");
				$("[data-banner]").addClass('d-none');
				container.removeClass('d-none');
			});
			<?php
				if( !empty($response) ):
					$key = array_keys($response)[0];
			?>
				$("#banner-switch").val(<?php echo "'{$key}'"; ?>);
				$("#banner-switch").get(0).dispatchEvent(new Event('change'));
			<?php endif; ?>
		</script>	
	<?php }); ?>
		
<?php require 'footer.php'; ?>