<?php 

if( empty($temp->status) ): 

	require_once __dir__ . '/deposit-error.php';

else: ?>

	<div class='text-center'>
	
		<div class=''>
			<img src='images/basic/confirm2.jpg' height='200px'>
		</div>
		
		<h2 class=''>
			Thank you for choosing <?php echo $config->get('site_name'); ?>
		</h2>
		
		<hr>
		
		<a class='btn btn-outline-primary btn-fw w-100 btn-lg' href='transaction-log.php'>
			View History
		</a>
		
	</div>
	
<?php endif; ?>