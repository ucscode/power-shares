<?php

events::addListener('@footer', function() {
	
	global $config, $__user;
	
	$announcement = $config->get('announcement');
	
	if( empty($announcement) ) return;
	
	$announcement = preg_replace_callback("/\{\{(\w+)\}\}/i", function($match) use($__user) {
		$key = $match[1];
		return $__user[ $key ] ?? "<i class='mdi mdi-alert-circle-outline'></i>";
	}, $announcement);
?>
	
	<!-- Modal -->
	<div class="modal fade" id="announceModal" tabindex="-1" aria-labelledby="announceModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="announceModalLabel">
					<i class='mdi mdi-alert-circle-outline me-1'></i> Announcement</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<?php echo $announcement; ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	
	<script>
		if( !sessionStorage.getItem('_announce') ) {
			const announceModal = new bootstrap.Modal('#announceModal', {
				focus: true,
				backdrop: 'static'
			});
			announceModal.show();
			sessionStorage.setItem('_announce', 1);
		};
	</script>

<?php });