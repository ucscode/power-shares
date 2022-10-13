
	<a href='<?php echo $_SERVER['PHP_SELF']; ?>' class='btn btn-warning btn-sm inline-block mb-4'>
		<i class='fas fa-arrow-left'></i>
	</a>
	
	<div class='text-center'>
		
		<img src='images/basic/error1.jpg' height="70px">
		
		<h3 class='mt-3'>Something went wrong!</h3>
		
		<hr>
		
		<form method='post'>
			<?php foreach( $_POST as $key => $value ): ?>
			<input type='hidden' name='<?php echo $key; ?>' value='<?php echo $value; ?>'>
			<?php endforeach; ?>
			<div class='form-group'>
				<button class='btn btn-primary btn-lg'>
					Retry <i class='fas fa-recycle ml-1'></i>
				</button>
			</div>
		</form>
		
	</div>