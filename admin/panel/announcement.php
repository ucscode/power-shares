<?php 

require __dir__ . '/sub-config.php';

require __dir__ . '/inc/for-announcement.php';

require 'header.php';

?>

	<?php section::title( 'Announcements', false ); ?>
	
	<div class='card'>
		<div class='card-body'>
			
			<?php sysfunc::html_notice( $temp->msg, $temp->status ?? null ); ?>
			
			<form method='POST' id='announcement'>
			
				<div class='form-group'>
					<div id='quill' data-select='default'></div>
					<textarea name='announcement' class='d-none'></textarea>
				</div>
			
				<div class=''>
					<button class='btn btn-primary btn-fw'>
						<i class='fas fa-save me-1'></i> Save
					</button>
				</div>
				
			</form>
			
		</div>
	</div>

<?php require 'footer.php'; ?>