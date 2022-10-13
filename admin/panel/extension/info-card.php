<?php

events::addListener('@footer', function() { ?>
	<script src='<?php echo sysfunc::url( __core_views . '/assets/vendors/jquery-circle-progress/js/circle-progress.min.js' ); ?>'></script>
<?php });


### DIVISION;

function circle_degree($numerator, $denominator) {
	if( empty($numerator) || empty($denominator) ) return 0;
	$result = $numerator / $denominator;
	return round($result, 2);
}


### CARD;

function info_card($name, $data) { 
	$__name = "dashboard-progress-{$name}";
?>

	<div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
		<div class="card">
			<div class="card-body text-center">
				<div class="dashboard-progress dashboard-progress d-flex align-items-center justify-content-center item-parent" id='<?php echo $__name; ?>'>
					<i class="<?php echo $data['icon']; ?> icon-md absolute-center text-dark"></i>
				</div>
				<p class="mt-4 mb-0"><?php echo $data['label']; ?></p>
				<h3 class="mb-0 font-weight-bold mt-2 text-dark"><?php echo $data['value']; ?></h3>
			</div>
		</div>
	</div>
	
	<?php 
		events::addListener('@footer', function() use($__name, $data) { 
		
			if( empty($data['gradient']) ) $data['gradient'] = array("#7922e5", "#1579ff");
			
			$gradient = array_map(function($value) {
				return "'{$value}'";
			}, $data['gradient']);
			
			$gradient = "[" . implode(",", $gradient) . "]";
			
			if( !isset($data['circle']) ) {
				if( is_numeric($data['value']) ) $data['circle'] = (float)$data['value'];
				else $data['circle'] = empty($data['value']) ? 0 : 1;
			};
			
			if( $data['circle'] < 0 ) $data['circle'] = 0;
			else if( $data['circle'] > 1 ) $data['circle'] = 1;
			
	?>
	
		<script>
			$(function() {
				$(<?php echo "'#{$__name}'"; ?>).circleProgress({
					value: <?php echo $data['circle']; ?>,
					size: 125,
					thickness: 7,
					startAngle: 80,
					fill: {
						gradient: <?php echo $gradient . "\n"; ?>
					}
				});
			});
		</script>
		
	<?php });
	
};


