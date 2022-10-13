<?php

require __dir__ . '/sub-config.php';

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) include "inc/for-deposit.php";

require_once "header.php";

/*
	$rates = json_encode((new forex())->export_rates());
	$temp->HTMLFooter[] = "<script>var rates = '{$rates}';</script>";
*/

?>

<?php section::title( "Deposit" ); ?>

<div class="row">
	
	<div class='col-lg-8 m-auto'>
		<div class='card'>
			<div class='card-body'>
				
				<div class='mb-2'>
					<?php sysfunc::html_notice( $temp->error ?? null, $temp->status ?? null ); ?>
				</div>
				
				<form method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
				
					<?php
						
						switch( $_POST['section'] ?? null ) {
							case "payment":
								require_once __dir__ . '/sections/deposit-2.php';
								break;
							case "final":
								require_once __dir__ . '/sections/deposit-3.php';
								break;
							default:
								require_once __dir__ . '/sections/deposit-1.php';
						};
						
					?>
					
				</form>
				
			</div>
		</div>
	</div>
	
</div>
  
<?php require_once 'footer.php'; ?>  
