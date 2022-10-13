<?php

require __dir__ . '/sub-config.php';

   
if(isset($_POST['delete'])){
	
	$id = $_POST['id'];
	$sql = "DELETE FROM wallets WHERE id = $id";
	
	if (mysqli_query($link, $sql)) {
		$temp->status = !!($msg = "Wallet Successfully Deleted!");
	} else {
		$temp->status = !($msg = "Wallet Not Deleted! ");
	};
	
}
 


include 'header.php';

?>

<?php section::title("Wallet List", false); ?>

<div class="card">
	
    <div class='card-body'>
	
        <?php sysfunc::html_notice( $msg, $temp->status ?? null ); ?>

		<div class="table-responsive no-padding">
			<table id="table" class="table table-striped table-hover" cellspacing="0" >
				<thead>
					<tr class="info">
						<th>Network</th>
						<th>Address</th>
						<th>Icon</th>
						<th>Deposit</th>
						<th>Withdrawal</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					
						$sql= "SELECT * FROM wallets ORDER BY id DESC";
						$result = mysqli_query($link,$sql);
						
						if(mysqli_num_rows($result)):
							while($wallet = mysqli_fetch_assoc($result)):
					?>
					<tr class="primary">
						<td><?php echo $wallet['wallet_network'];?></td>
						<td><?php echo $wallet['wallet_addr'];?></td>
						<td><img src="paymenticon/<?php echo $wallet['wallet_image'];?>" width="42px"></td>
						<td><?php echo sysfunc::checker($wallet['for_deposit']); ?></td>
						<td><?php echo sysfunc::checker($wallet['for_withdrawal']); ?></td>
						<td>
							<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
								<input type='hidden' name='id' value='<?php echo $wallet['id']; ?>'>
								<button class="btn btn-danger" type="submit" name="delete" data-confirm="Delete <?php echo $wallet['wallet_network']; ?> address <br> Sure you want to proceed?">
									<span class="fa fa-trash"></span>
								</button>
								<a class="btn btn-primary" role="button" type='button' name="edit" href='wallet-add.php?id=<?php echo $wallet['id']; ?>'>
									<span class="fa fa-pencil-alt"></span>
								</button>
							</form>
						</td>
					</tr>
					<?php
							endwhile;
						endif;
					?>
				</tbody>
			</table>
		</div>

	 </div>
    <!-- /top tiles -->
</div>

<?php include 'footer.php'; ?>