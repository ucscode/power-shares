<?php

require __dir__ . '/sub-config.php';

require "inc/for-sdetails.php";

include 'header.php';

?>

<?php section::title( "Shares Detail" ); ?>

<?php sysfunc::html_notice($msg); ?>

<?php 

	$sql= "SELECT * FROM shared WHERE sid='$sid'";
	
		$result = mysqli_query($link,$sql);
		
		if(mysqli_num_rows($result)) {
			
			 $row = mysqli_fetch_assoc($result);  
					
			if(isset($row['status']) &&  $row['status']== '1'){
				$sec = 'Active &nbsp;<i style="font-size:20px;" class="fa fa-check-circle text-success" ></i>';
			}else{
				$sec ='Not Active &nbsp;<i class="fa  fa-times text-danger" style=" font-size:20px;color:red"></i>';
				$usd = 'No Shares';
			}
			
			if(isset($row['date']) &&  $row['date']== '0'){
				$date = 'Not Yet Started &nbsp;<i style="background-color:red;color:#fff; font-size:20px;" class="fa fa-times" ></i>';
				$start= (int)500;
			}else{
				$date = $row['date'];
				$start= $row['date'];
			}

    
     ?>
		 
		<form action="sdetails.php?id=<?php echo $sid;?>" method="post">
			<div class="row ">
				<div class="col-md-10 col-lg-6 col-12 mx-auto mx-lg-0">
					<div class="box box-inverse bg-dark">
					
						<div class="box-body text-center">
							<h2 class="mb-2 text-bold text-capitalize text-warning">
								<?php echo $row["sharescat"];?>
							</h2>
							<h6 class='text-capitalize'>
								<em><?php echo $row["sharesubcat"];?></em>
							</h6>
							<h4><?php echo $row["pname"];?></h4>
							<h6><?php echo $sec;?></h6>
							<div class='my-3'>
								<input name="amount" step="0.01" required class='form-control form-control-lg' placeholder="Amount to invest" type="number" style="border-radius:5px;width:100%;">
							</div>
							<h6 class> <?php echo $row["increase"]; ?>% increase</h6>
							<input name="email"  type="hidden" value="<?php  echo $_SESSION['email']?>">
							<input name="sharescat"  type="hidden" value="<?php echo $row["sharescat"];?>">
							<input name="sharesubcat"  type="hidden" value="<?php echo $row["sharesubcat"];?>">
							<input name="sid"  type="hidden" value="<?php echo $row["sid"];?>">
							<input name="pname"  type="hidden" value="<?php echo $row["pname"];?>">
							<input name="increase"  type="hidden" value="<?php  echo $row['increase']?>">
							<button class="btn btn-success" type="submit" name="activate">Buy/Activate Shares </button>
						</div>
						
					</div>
				</div>
			</div>
		</form>

<?php 

	}; 

    include 'footer.php';
	
?>   